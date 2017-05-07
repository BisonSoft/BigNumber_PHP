# BigNumber_PHP
PHP class for computing arbitrary-length integers

## Installation
Just download and include __calculator.php__ in your project:
```include 'calculator.php';```

## Usage
Class contains 8 static methods:  
- __Calculator::add__( string $number_1, string $number_2, [bool $num_verification = true] )  
 Function calculate __addition__ and returns a string ( number_1 + number_2 )  

 - __Calculator::subtr__( string $number_1, string $number_2, [bool $num_verification = true] )  
 Function calculate __subtraction__ and returns a string ( number_1 - number_2 )  
 
  - __Calculator::diff__( string $number_1, string $number_2, [bool $num_verification = true] )  
 Function calculate __difference__ and returns a string ( ABS(number_1 - number_2) )  
 
  - __Calculator::multip__( string $number_1, string $number_2, [bool $num_verification = true] )  
 Function calculate __multiplication__ and returns a string ( number_1 * number_2 )  

  - __Calculator::div__( string $number_1, string $number_2, [int $precision = 10], [bool $num_verification = true] )  
 Function calculate __division__ and returns a string ( number_1 / number_2 )  
 __$precision__ represent number of digits after decimal point ( it is set default to 10 )
 
   - __Calculator::mod__( string $number_1, string $number_2, [bool $num_verification = true] )  
 Function calculate __modulo__ and returns a string ( number_1 % number_2 )  
 
    - __Calculator::compare__( string $number_1, string $number_2, [bool $num_verification = true] )  
 Function compares number_1 and number_2 and returns:  
 ( 1 ) if number_1 > number_2  
 ( 0 ) if number_1 = number_2  
 (-1 ) if number_1 < number_2  
 
 - __valid_number__(&$number)  
 Function checks if number is in the proper format and returns bool
 
 - __$num_verification = true__  
 Each function has one optional parameter, and by defauld it is set to TRUE.  
 It checks if entered numers are in proper format.  
 It is a performance parameter, and if you make this chek using __valid_number__ function, this parameter can be set to FALSE  
 
 -  __Proper format for numbers__  
 All numbers must be entered as strings  
 If variable is __int__ it can be casted to string ( $i = 13; $str = (string)$i; )  
 Numbers can not contain decimal points nor notations ( +/- )  
 All preceding zeros will be omitted
 $n = '12555'; and $n = '00012555'; are valid numbers  
 $n = '-4456'; and $n = '1.234567'; are invalid numbers  
 
 - __Special cases__  
 In some cases functions will return __ERROR__ ( string 'E' )  
 Example:  
 dividing by zero ( Calculator::div('15', '0') ) will return string 'E'
 
