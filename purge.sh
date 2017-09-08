# Small cmd line arg convenience function
function arg_exists {
    for a in ${BASH_ARGV[*]}; do
	if [ "$a" == "$1" ]; then
	    return 1
	fi
    done
    return 0
}

# Check some cmd line args
rmflag=''
printflag=' and all its volumes'
if [ $(arg_exists "--volumes") ]; then
    $rmflag='-v'
fi

containers=("moodledocker_webserver_1" "moodledocker_selenium_1" "moodledocker_mailhog_1" "moodledocker_phpmyadmin_1" "moodledocker_db_1")
# Stop the containers
for i in ${containers[*]}; do
    echo "Stopping container $i..."
    sudo docker stop $i
    echo "Deleting container $i$printflag..."
    sudo docker rm $rmflag $i
done

images=("moodlehq/moodle-php-apache:7.0" "phpmyadmin/phpmyadmin" "mysql:5" "mailhog/mailhog" "selenium/standalone-firefox:2.53.1")
# Delete the relevant images
if [ $(arg_exists "--images") ]; then
    for i in ${images[*]}; do
	echo "Removing image $i..."
	sudo docker rmi $i
    done
    if [ $(arg_exists "--untagged") ]; then
	echo "Removing all untagged images..."
	sudo docker rmi $(sudo docker images -a | grep "^<none>" | awk '{print $3}')
    fi
fi

# Show that everything has been removed
echo "Showing containers (sudo docker ps -a)..."
sudo docker ps -a
if [ $(arg_exists "--images") ]; then
    echo "Showing images (sudo docker images -a)..."    
    sudo docker images -a
fi
if [ $(arg_exists "--volumes") ]; then
    echo "Showing volumes (sudo docker volume ls)"
    sudo docker volume ls
fi


#sudo docker stop $(sudo docker ps -a -q)
#sudo docker rm $(sudo docker ps -a -q)
#sudo docker rmi $(sudo docker images -a -q)
#sudo docker volume rm $(docker volume ls)
