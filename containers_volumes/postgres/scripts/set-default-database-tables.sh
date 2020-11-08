#!\bin\bash

sql -U postgres -a -f /project_files/scripts/create-myposts-database.sql
sql -U postgres -d myposts -a -f /project_files/scripts/create-table-users.sql
sql -U postgres -d myposts -a -f /project_files/scripts/create-table-posts.sql 
