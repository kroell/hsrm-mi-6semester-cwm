echo "************************************************"
echo "sudo ant -f build.xml clean"
echo "************************************************"
sudo ant -f build.xml clean
#read -p "Press [Enter] to go on..."

echo "************************************************"
echo "sudo ant -f build.xml zip-project"
echo "************************************************"
sudo ant -f build.xml zip-project
#read -p "Press [Enter] to go on..."

echo "************************************************"
echo "sudo ant -f build.xml install-amp"
echo "************************************************"
sudo ant -f build.xml install-amp
#read -p "Press [Enter] to go on..."

echo "************************************************"
echo "sudo ant -f build.xml deploy-amp"
echo "************************************************"
sudo ant -f build.xml deploy-amp
#read -p "Press [Enter] to go on..."

echo "************************************************"
echo "sudo ant -f build.xml deploy-share-jar"
echo "************************************************"
sudo ant -f build.xml deploy-share-jar
#read -p "Press [Enter] to go on..."
