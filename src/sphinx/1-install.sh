#!/bin/bash
SPHINX_RELEASE="2.1.6"
SPHINX_DIR="/var/lib/sphinx"


clear
echo "HELLO STUDENT! If you are running this script without root permissions (e.g: using 'sudo') the installation will fail. Press a key to continue or Ctrl-C to abort."
read keypress

sudo yum -y install mysql-devel
mkdir -p $SPHINX_DIR/{data,run,log,etc}
cp demo.conf $SPHINX_DIR/etc

cd /tmp
wget http://sphinxsearch.com/files/sphinx-$SPHINX_RELEASE-release.tar.gz
wget http://snowball.tartarus.org/dist/libstemmer_c.tgz

tar xvzf sphinx-$SPHINX_RELEASE-release.tar.gz
tar xvzf libstemmer_c.tgz && cp -rfp libstemmer_c/* sphinx-$SPHINX_RELEASE-release/libstemmer_c

cd sphinx-$SPHINX_RELEASE-release
./configure --with-mysql --prefix=$SPHINX_DIR --with-libstemmer
make install
mv api $SPHINX_DIR/


