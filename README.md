# task-cli-php

# Adding a new task

php cli.php add "Buy groceries"
# Output: Task added successfully (ID: 1)

# Updating and deleting tasks
php cli.php update 1 "Buy groceries and cook dinner"
php cli.php delete 1

# Marking a task as in progress or done
php cli.php mark-in-progress 1
php cli.php mark-done 1

# Listing all tasks
php cli.php list

# Listing tasks by status
php cli.php list done
php cli.php list todo
php cli.php list in-progress

# Project Url
https://roadmap.sh/projects/task-tracker