#!/bin/bash

userfile=profs

username=$(cat profs | tr 'A-Z'  'a-z')

password=$username@123

for user in $username
do
    useradd $user
    echo "$username:$password" | chpasswd
done

echo "$(wc -l profs) users have been created" 
tail -n$(wc -l profs) /etc/passwd
