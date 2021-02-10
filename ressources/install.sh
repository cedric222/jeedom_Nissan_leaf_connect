touch /tmp/dependancy_nissan_leaf_connect_in_progress
echo 0 > /tmp/dependancy_nissan_leaf_connect_in_progress
echo "********************************************************"
echo "*             Installation des dépendances             *"
echo "********************************************************"
apt-get update
echo 50 > /tmp/dependancy_nissan_leaf_connect_in_progress
sudo apt-get install -y php-dev libmcrypt-dev php-pear
sudo pecl channel-update pecl.php.net
sudo pecl install channel://pecl.php.net/mcrypt-1.0.2
echo 100 > /tmp/dependancy_nissan_leaf_connect_in_progress
echo "********************************************************"
echo "*             Installation terminée                    *"
echo "********************************************************"
rm /tmp/dependancy_nissan_leaf_connect_in_progress
