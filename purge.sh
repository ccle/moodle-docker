# Check some cmd line args

volumes=false
images=false
untagged=false
for a in ${BASH_ARGV[*]}; do
    if [ "$a" == "--volumes" ]; then
	volumes=true
    elif [ "$a" == "--images" ]; then
	images=true
    elif [ "$a" == "--untagged" ]; then
	untagged=true
    elif [ "$a" == "--all" ]; then
	volumes=true
	images=true
	untagged=true
    fi
done

rmflag=''
printflag=''
if [ "$volumes" = true ]; then
    printflag=' and all its volumes'
    rmflag='-v'
fi

containers=("moodledocker_webserver_1" "moodledocker_selenium_1" "moodledocker_mailhog_1" "moodledocker_phpmyadmin_1" "moodledocker_db_1")
# Stop the containers
for i in ${containers[*]}; do
    echo "Stopping container $i..."
    sudo docker stop $i
    echo "Deleting container $i$printflag..."
    sudo docker rm $rmflag $i
done

imagenames=("moodlehq/moodle-php-apache:7.0" "phpmyadmin/phpmyadmin" "mysql:5" "mailhog/mailhog" "selenium/standalone-firefox:2.53.1")
# Delete the relevant images
if [ "$images" = true ]; then
    for i in ${imagenames[*]}; do
	echo "Removing image $i..."
	sudo docker rmi $i
    done
    if [ $untagged ]; then
	echo "Removing all untagged images..."
	sudo docker rmi $(sudo docker images -a | grep "^<none>" | awk '{print $3}')
    fi
fi

# Delete the main volume
if [ "$volumes" = true ]; then
    sudo docker volume rm moodledocker_data
fi

# Show that everything has been removed
echo "Showing containers (sudo docker ps -a)..."
sudo docker ps -a
if [ "$images" = true ]; then
    echo "Showing images (sudo docker images -a)..."    
    sudo docker images -a
fi
if [ "$volumes" = true ]; then
    echo "Showing volumes (sudo docker volume ls)"
    sudo docker volume ls
fi


#sudo docker stop $(sudo docker ps -a -q)
#sudo docker rm $(sudo docker ps -a -q)
#sudo docker rmi $(sudo docker images -a -q)
#sudo docker volume rm $(docker volume ls)
