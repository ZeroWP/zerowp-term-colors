#!/usr/bin/env bash

PLUGIN_SLUG="${PWD##*/}"

sed -i -e "s/__STABLE_TAG__/$TRAVIS_TAG/g" ./src/readme.txt
sed -i -e "s/__STABLE_TAG__/$TRAVIS_TAG/g" ./src/${PLUGIN_SLUG}.php

cat ./src/readme.txt

# 1. Clone complete SVN repository to separate directory
svn co "https://plugins.svn.wordpress.org/$PLUGIN_SLUG" ./svn  --depth immediates

# 2. Copy git repository contents to SNV trunk/ directory
cp -R ./src/* ./svn/trunk
cp -R ./wp_org/assets/* ./svn/assets

# 3. Switch to SVN repository
cd ./svn

svn add trunk/* --force \
        --username ${SVN_USERNAME} \
        --password ${SVN_PASSWORD} \
        --non-interactive
        
svn ci  --message "Release $TRAVIS_TAG" \
        --username ${SVN_USERNAME} \
        --password ${SVN_PASSWORD} \
        --non-interactive

svn copy https://plugins.svn.wordpress.org/${PLUGIN_SLUG}/trunk \
        https://plugins.svn.wordpress.org/${PLUGIN_SLUG}/tags/${TRAVIS_TAG} \
        -m "Release ${TRAVIS_TAG}"
        --username ${SVN_USERNAME} \
        --password ${SVN_PASSWORD} \
        --non-interactive
