## PHP Starter Template

### Setup
1. run `npm install` to install dependencies
2. run `gulp run setup` to pull in most recent bootstrap files
3. Create a database with at least one table **users** (Use `database.sql` to set up a basic table)
4. Enter database credentials in `private/db_credentials.php`


### Development
run `npm run dev`

### Build
run `npm run build`

### Future Ideas
- Ability to add amazon list links (or other sites) to profile

### Troubleshooting
There are some common issues when installing this on your server.
1. Wrong database credentials
Check the `db_credentials.php` file in the `private` folder

2. Dynamic URLs
Some servers don't like the dynamic url so in `initialize.php` on line 20, change `+ 5` to `+ 0`

3. Autoloading Classes
Some servers don't like autoloading classes. That's why in `initialize.php` we give you 3 options: Individually, By Folder, Auto. Try out different ones if it's not working.