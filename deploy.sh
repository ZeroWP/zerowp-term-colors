#!/usr/bin/env bash

# 1. Clone complete SVN repository to separate directory
svn co $SVN_REPOSITORY ./svn

# 2. Copy git repository contents to SNV trunk/ directory
cp -R ./src/* ./svn/trunk/
cp -R ./assets/* ./svn/assets/

# 3. Switch to SVN repository
cd ./svn/

# 7. Create SVN tag
svn cp trunk tags/$TRAVIS_TAG

# 8. Push SVN tag
svn ci  --message "Release $TRAVIS_TAG" \
        --username $SVN_USERNAME \
        --password $SVN_PASSWORD \
        --non-interactive
