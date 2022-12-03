#!/bin/bash

userfile=/tmp/userlist 

username=$(cat /tmp/userlist | tr 'A-Z'  'a-z')

password=$username@123

for user in $username
do
    useradd $user
    echo $password | passwd --stdin $user
done

echo "$(wc -l /tmp/userlist) users have been created" 
tail -n$(wc -l /tmp userlist) /etc/passwd
