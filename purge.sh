sudo docker rmi $(sudo docker images -a -q)
sudo docker stop $(sudo docker ps -a -q)
sudo docker rm $(sudo docker ps -a -q)
