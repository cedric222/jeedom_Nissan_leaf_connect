touch /tmp/dependancy_nissan_leaf_connect_in_progress
echo 0 > /tmp/dependancy_nissan_leaf_connect_in_progress
echo "********************************************************"
echo "*             Installation des dépendances             *"
echo "********************************************************"
apt-get update
echo 50 > /tmp/dependancy_nissan_leaf_connect_in_progress
#sudo apt-get -y install php-mcrypt (for php7 only)
sudo apt-get -y install php5-mcrypt 
echo 100 > /tmp/dependancy_nissan_leaf_connect_in_progress
echo "********************************************************"
echo "*             Installation terminée                    *"
echo "********************************************************"
rm /tmp/dependancy_nissan_leaf_connect_in_progress
