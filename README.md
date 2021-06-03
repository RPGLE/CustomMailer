# CustomMailer
A Custom PHP Mailer using Zend for use on the IBMi Power Systems. This works for SMTP sending, but does not support TLS. Currently, the mailer only supports HTML sending.

This class requires:
- The Zend Server to be used
- Zend Framework 2 to be installed

Introduction information about the Zend Mail Service is here: https://framework.zend.com/manual/2.4/en/modules/zend.mail.introduction.html

# To Use the Class
Basic configuration neeeds to be updated within CustomMailer.php:
- Update the service provider address, host and port number
- Update the default from email address.

Once the class has been updated with your configurations, within the calling program, add the calling class to the top of the program with the address path where the class has been saved. For example, if the file was added in the IFS within "/esdi/applications/php", the include would be as below:
```php 
require_once('/esdi/applications/php/CustomMailer.php');
```
Now that the class has been included, to send the email, prepare some html into a variable as well as the from email, to email and the subject. For example, if I wanted to send "Hello World" to hello@world.com from goodbye@world.com with the subject "Good morning", the call would look as follows.
```php
$emailContent = '<html><head></head><body style="font-family: Arial, Verdana, Sans-serif;font-size: 10px;background:#ffffff">' 
              . '<p>Hello World</p></body></html>';
$emailObject = new CustomMailer('hello@world.com', 'Good morning', $emailContent, 'goodbye@world.com');
$emailObject->sendHTMLEmail();
```
