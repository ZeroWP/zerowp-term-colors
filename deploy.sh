#!/usr/bin/env bash

PLUGIN_SLUG="${PWD##*/}"

echo "https://plugins.svn.wordpress.org/$PLUGIN_SLUG"

echo "Change plugin version to $TRAVIS_TAG"
sed -i -e "s/__STABLE_TAG__/$TRAVIS_TAG/g" ./src/readme.txt
sed -i -e "s/__STABLE_TAG__/$TRAVIS_TAG/g" ./src/${PLUGIN_SLUG}.php

# Clone complete SVN repository to separate directory
echo "Checkout https://plugins.svn.wordpress.org/$PLUGIN_SLUG to ./svn"
svn co "https://plugins.svn.wordpress.org/$PLUGIN_SLUG" ./svn  --depth immediates

echo "Files:"
ls ./svn

# Copy git repository contents to SNV trunk/ directory
echo "Copy from ./src/ to ./svn/trunk/"
cp -R ./src/* ./svn/trunk/

echo "Copy from ./wp_org/assets/ to ./svn/assets/"
cp -R ./wp_org/assets/* ./svn/assets/

# Switch to SVN repository
echo "Switch to ./svn"
cd ./svn

# Create SVN tag
echo "Copy from trunk to tags/$TRAVIS_TAG"
cp -R ./trunk/* ./tags/$TRAVIS_TAG

# Push SVN tag
echo "Commit $TRAVIS_TAG"
svn ci  --message "Release $TRAVIS_TAG" \
        --username $SVN_USERNAME \
        --password $SVN_PASSWORD \
        --non-interactive
