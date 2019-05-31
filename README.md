# ActuallyGoodPhpCS
A php coding standard, that does not suck.

I code a lot with JS and use eslint with standardJS. As there is no Coding Standard, that is ever so slightly near that, so I created one.

Important was, that the coding standard is supported by a linter that runs with VS Code, as this is my main development IDE.

Have fun with it and give love to the projects, this does depend on ♥

## How to install

### 3rd party dependencies

- You will need to install this standard for unused variable support: https://github.com/sirbrillig/phpcs-variable-analysis/
- Of course you will need phpcs: https://github.com/squizlabs/PHP_CodeSniffer

### To install

- Clone this repo to your local machine
- Now set the installed_paths of phpcs to find this and the unused variable standard. For this execute following code (In case you want to install globally):

*HINT: Installed paths needs to get a comma seperated list of the paths of all standards, beside the in-built.*

```
phpcs --config-set installed_paths "<GLOBAL_COMPOSER_PATH>\Composer\vendor\sirbrillig\phpcs-variable-analysis,<PATH_OF_THIS_REPO>\ActuallyGoodPhpCS"
```

## Language features

### Supported

- [x] Max line length 120 chars
- [x] Linux line endings "\n"
- [x] Force single quotes, if there is no variable in the string
- [x] Newline at end of file
- [x] Space after function name and after parantheses. Curly brace on same line.
- [x] Force 1 tab intendention
- [x] Enforce short array declarations
- [x] Force array formatting
  - Single line array, with spaces after every comma
  - Multi line array, with only one value per line and not on the same line as the opening bracket
- [x] No duplicate class names
- [x] FIXMEs will be shown as error, so you won't forget it
- [x] TODOs will be shown as warnings, so you won't forget these either
- [x] No inline control structures (e.g. Inline if statements)
- [x] No unnecessary string concat

```
'Hello' . 'World' // This is not allowed
```

- [x] Force camel case of method names
- [x] Force camel case of memeber variables
- [x] Disallow deprecated functions
- [x] Force lowercase for:
  - Constants
  - Types
  - Keywords
- [x] Forbid any character before PHP opening tag
- [x] Forbid these functions:
  - delete
  - sizeof
- [x] Show warning for all unused variables
- [x] Force "elseif" instead of "else if"
- [x] No unnecessary whitespace
- [x] Enforce doc comment formatting
- [x] Check for BOM
- [x] Forbid multiple statements in one line
- [x] Space required after type cast
- [x] Forbid PHP4 constructors
- [x] Warning if nesting level is bigger than 5
- [x] Error if nesting level is bigger than 10
- [x] Forbid silencing of errors
- [x] Other cool stuff. Look in the phpcs.xml, the comments in there descibe all includes.
- [x] Space surrounding dots to concat strings
- [x] Forbid empty lines at end or beginning of function and class declaration
- [x] Force function and variable names not in classes to snake_case

### Planned features

- [ ] Multi line if statement formatting
- [ ] Forbid multiple empty lines in whole file
- [ ] dirname(__FILE__) => __DIR__
- [ ] No content on same line as after closing brace
- [ ] Allow intances of classes in camelCase

### ToDo

- [ ] Make all functions declared in this standard conform to the standard


## Feel free to send me pull requests.

Only changes are allowed that bring this standard closer to standardJS. (Except the omission of semicolons of course)