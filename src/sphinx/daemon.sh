#!/bin/bash
# Albert Lombarte
# alombarte@gmail.com
# Simple script to (re)index, start or stop Sphinx
#
SPHINX_PATH=/var/lib/sphinx/bin
SPHINX_CONFIG=/var/lib/sphinx/etc/demo.conf

ACTION=$1

case ${ACTION} in
	  create)
	  ${SPHINX_PATH}/indexer -c $SPHINX_CONFIG --all
	  ;;
	  rotate)
	  ${SPHINX_PATH}/indexer -c $SPHINX_CONFIG --all --rotate
	  ;;
	  start)
	  ${SPHINX_PATH}/searchd -c $SPHINX_CONFIG
	  ;;
	  stop)
	  killall searchd
	  ;;
	  *)
	echo "Sphinx bash helper:"
       	echo "--USAGE: $0 {create|rotate|start}"
       	echo " <rotate>: If the index is already running, reindexes and applies changes"
       	echo " <create>: Creates the index for the very first time"
       	echo " <start>: Exactly, starts it."
       	exit 1;
       	;;
esac
