# The Holiday Wishlist

## Setup
1. run `npm install` to install dependencies
2. run `gulp run setup` to pull in most recent bootstrap files
3. Create a database with at least one table **users** (Use `database.sql` to set up a basic table)
4. Enter database credentials in `private/db_credentials.php`


## Development
run `npm run dev`

## Build
run `npm run build`

## Versioning

### v2.0.0
- Added a new no_pair feature which checks database to make sure that specified people can't be paired up
- Added a new no_pair feature which makes sure two people can't be paired up again for at least 3 years

## Future Ideas
- Ability to add amazon list links (or other sites) to profile
- Add kids vs. adults exchanges
- Add people who can be viewers only. They can add their items but can't be part of the exchange
- Make it multi-group or multi-family and make your wishlist of items carry across if you are in multiple groups

## Troubleshooting
There are some common issues when installing this on your server.
1. Wrong database credentials
Check the `db_credentials.php` file in the `private` folder

2. Dynamic URLs
Some servers don't like the dynamic url so in `initialize.php` on line 20, change `+ 5` to `+ 0`

3. Autoloading Classes
Some servers don't like autoloading classes. That's why in `initialize.php` we give you 3 options: Individually, By Folder, Auto. Try out different ones if it's not working.