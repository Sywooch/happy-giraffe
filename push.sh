git checkout develop
git pull origin develop
git add -A
git commit -m 'release the kraken'
git push origin develop
git checkout master
git pull origin master
git merge --no-ff develop
git push origin master
