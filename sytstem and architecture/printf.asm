#  Zijian Ling
#This a program that imitate the printf function in C
#%d %c %s %S %%, indicate print integer,ASCII char, user input string, user input string all character in upper, and '%' respectively

#I have put ten normal cases and ten abnormal cases in another two .txt file attached

#warning1:when you want to use %c to print char, when you enter single char, you should only enter char without press "enter", beacause MARS will automatically read the "enter" to store in remaining variable!

#warning2:when you want to use %s to print string, the MARS will read the "\n"--newline symbol in the end of every string variable,so there will be a newline after each string variable

#warning3:when you want to print '%', whatever you enter, the output will only be '%'

#warning4: when you want to use %d to print integer, but enter non-integer, MARS will set the value of the register that should be stored integer to 0

#warning5: This program cannot handle overflow, beacause if i want to detect overflow,the register inside program should have overflow first, so i can not detect it

#Simple explanation: first user read-part function to read user input, when meet '%+', the program will according to character after '%' to read variable
#if all user input is valid,then pass them with user input string to print-part function to print the output.If invalid, program will print warning prompt

#This program can handle %d but you enter non-integer, %c but you enter non-char,related prompt will been print.

#The reason for this program use so many read buffers and load variables respectively is that when read string,one string buffer can only be one address for user input

#NOTICE: all comments are written ABOVE or AFTER the line



.data 
printf_buf: .space 2
read_buf:   .space 1024
str_buf1:   .space 1024
str_buf2:   .space 1024
str_buf3:   .space 1024
char_buf1:  .space 1024
char_buf2:  .space 1024
char_buf3:  .space 1024
int_buf1:   .space 1024
int_buf2:   .space 1024
int_buf3:   .space 1024
prompt0:    .asciiz "please enter what you want to print\n"
prompt1:    .asciiz "please enter first variable\n"
prompt2:    .asciiz "please enter second variable\n"
prompt3:    .asciiz "please enter third variable\n"
prompt4:    .asciiz "\n"
prompt5:    .asciiz "The result is:\n"
prompt6:    .asciiz "Error! You have enter non-char, you should enter ASCII char here.\n" 
prompt7:    .asciiz "Error! You have enter non-integer, you should enter integer here.\n"
prompt8:    .asciiz "Error! You enter nothing, you should enter integer here.\n"


.text
.globl main

main:
    
    li $v0, 4
    la $a0, prompt0                             #print prompt0
    syscall

    li $v0, 8
    la $a0, read_buf                            #read user input string
    li $a1, 1024                       
    syscall 

  
read:
    la $t7, ($a0)                               #store address in $t7
    move $s0, $a0                               #move address to $s0
    li $s4, 0                                   #$s4 = 0, counter the number of variable
    la $s6, printf_buf                          #$s6 used for putc

read_loop:
    lb $s5, 0($s0)                              #load byte from user input
    addu $s0, $s0, 1                            #address+1
    beq $s4, 3, read_end                        #if there are already 3 variable, than ignore later variable
    beq $s5, '%', read_fmtpre                   #if meet '%', jump to read_fmtpre
    beq $0, $s5, read_end                       #if there is no more character, then jump to read_end
    j  read_loop                                #none of above satisfied, jump to read_loop


read_fmtpre:
    beq $s4, 0, loadprompt1                     #if it is the first variable program have meet, jump to loadprompt1
    beq $s4, 1, loadprompt2                     #if it is the second variable program have meet, jump to loadprompt2
    beq $s4, 2, loadprompt3                     #if it is the third variable program have meet, jump to loadprompt3

read_fmt:
    lb $s5, 0($s0)                              #load byte after the '%'
    addu $s0, $s0, 1                            #address+1
    beq $s4,  3, read_loop                      #if there are already 3 variable, go back to read_loop

    beq $s5, 'd', read_int                      #if meet 'd', jump to read_int

    beq $s5, 's', read_str                      #if meet 's', jump to read_str

    beq $s5, 'c', read_char                     #if meet 'c', jump to read_char

    beq $s5, '%', read_str                      #if meet '%', jump to read_str

    beq $s5, 'S', read_str                      #if meet 'S', jump to read_str

    j  read_loop                                #go back to read_loop 

read_shift_args:
    beq $s4, 0, loadvar1                        #if it is first variable program read, jump to loadvar1
    beq $s4, 1, loadvar2                        #if it is first variable program read, jump to loadvar1
    beq $s4, 2, loadvar3                        #if it is first variable program read, jump to loadvar1

read_shift_args_final:
    addi $s4, $s4, 1                            #the number of variable +1
    j read_loop                                 

read_int:                             
                    
    li $v0, 4                                   #print corresponding loadprompt  
    syscall 

    beq $s4, 0, read_int_buf1                   #if it is the first variable program read, jump to read_int_buf1
    beq $s4, 1, read_int_buf2                   #if it is the second variable program read, jump to read_int_buf2
    beq $s4, 2, read_int_buf3                   #if it is the third variable program read, jump to read_int_buf3

read_int_begin:
    
    li $t0, 1                                   #store expon of 10
    li $t4, 0                                   #$t4 to store the integer transformed from string
    li $t5, 1
    
    lb $t6, ($a0)                               #load byte of the variables user input                     
    beq $t6, '\n', empty_int                    #if user just press enter without any other input, jump empty_int
    sb $t6, ($a0)                               #save byte
  
read_int_loop:
    lb $t6, ($a0)                               #load byte of the variables user input                     
    beq $t6, '\n', store_int                    #meet '\n', jump to store_int
    blt $t6, 48, not_int                        #the ASCII of digit of 0-9 is between 48-57            
    bgt $t6, 57, not_int                        #if out of range, the user input is not integer
    addi $t6, $t6, -48                          #get the digit itself
    mul $t4, $t4, 10                            #$t4*10
    add $t4, $t4, $t6                           #Add the new number to the single digit of $t4
    addi $a0, $a0, 1                            #address+1
    j read_int_loop                             #jump back to read_int_loop
   
    
strlen1:
	li $t0, 0                                   #store the length of string
	la $a0, int_buf1                            #load the address of int_buf1

strlen_loop1:
	lb $t6, ($a0)                               #load byte
	bne $t6, $0, strlen_next1                   #if there byte is not empty, jump to strlen_next1
    sb $t6, ($a0)                               
	move $a0, $t0                               #move the length of string to $a0
	jr $ra                                      #jump to return address

strlen_next1:
    sb $t6, ($a0)
	addi $a0, $a0, 1                            #address+1
	addi $t0, $t0, 1                            #the length of string +1
	j strlen_loop1                              #jump to strlen_loop1



strlen2:
	li $t0, 0                                   #store the length of string
	la $a0, int_buf2                            #load the address of int_buf2

strlen_loop2:
	lb $t6, ($a0)
	bne $t6, $0, strlen_next2                   #if there byte is not empty, jump to strlen_next2
    sb $t6, ($a0)
	move $a0, $t0                               #move the length of string to $a0
	jr $ra                                      #jump to return address

strlen_next2:
    sb $t6, ($a0)
	addi $a0, $a0, 1                            #address+1
	addi $t0, $t0, 1                            #the length of string +1
	j strlen_loop2                              #jump to strlen_loop2




strlen3:
	li $t0, 0                                   #store the length of string
	la $a0, int_buf3                            #load the address of int_buf3

strlen_loop3:
	lb $t6, ($a0)
	bne $t6, $0, strlen_next3                   #if there byte is not empty, jump to strlen_next3
    sb $t6, ($a0)
	move $a0, $t0                               #move the length of string to $a0
	jr $ra                                      #jump to return address

strlen_next3:
    sb $t6, ($a0)
	addi $a0, $a0, 1                            #address+1
	addi $t0, $t0, 1                            #the length of string +1
	j strlen_loop3                              #jump to strlen_loop3


store_int:
    move $s7,$t4                                #move integer result to $s7
    move $t4, $0                                #clear $t4
    j read_shift_args                           #jump to read_shift_args

empty_int:
    move $s7, $0   
    li $v0, 4
    la $a0, prompt8                             #if user press enter only,print prompt8
    syscall
    j read_shift_args                           #jump to read_shift_args

not_int:
    move $s7, $0                                #clear $s7
    li $v0, 4
    la $a0, prompt7                             #if user input is not integer,print prompt7
    syscall
    j read_shift_args                           #jump to read_shift_args


read_int_buf1:
    
    li $v0, 8
    la $a0, int_buf1                            #read user input store in int_buf1
    li $a1, 1024    
    syscall

    jal strlen1                                 #counter the length of user input
    move $s6, $a0
    addi $s6, $s6, -1                           #length-1, beacause strlen will read '\n' in the end of string
    la $a0, int_buf1                            #load address of user input
    
    j read_int_begin                            

read_int_buf2:
    
    li $v0, 8
    la $a0, int_buf2                            #read user input store in int_buf1
    li $a1, 1024
    syscall
    jal strlen2                                 #counter the length of user input
    move $s6, $a0
    addi $s6, $s6, -1                           #length-1, beacause strlen will read '\n' in the end of string
    la $a0, int_buf2                            #load address of user input
    
    j read_int_begin

read_int_buf3:
    
    li $v0, 8
    la $a0, int_buf3                            #read user input store in int_buf1
    li $a1, 1024
    syscall

    jal strlen3                                 #counter the length of user input
    move $s6, $a0
    addi $s6, $s6, -1                           #length-1, beacause strlen will read '\n' in the end of string
    la $a0, int_buf3                            #load address of user input
    
    j read_int_begin


read_str:                            
	                 
    li $v0, 4                                   #print corresponding loadprompt  
    syscall 


    beq $s4, 0, read_str_buf1                   #if it is the first variable program read, jump to read_str_buf1
    beq $s4, 1, read_str_buf2                   #if it is the second variable program read, jump to read_str_buf2
    beq $s4, 2, read_str_buf3                   #if it is the third variable program read, jump to read_str_buf3

 read_str_store:
    la $s7, ($a0)                               #load user input to $s7
    move $a0, $0                                #clear $a0
    j read_shift_args                   
	 
read_char:        

    li $v0, 4                                   #print corresponding loadprompt  
    syscall 

    

    beq $s4, 0, read_char_buf1                  #if it is the first variable program read, jump to read_char_buf1
    beq $s4, 1, read_char_buf2                  #if it is the second variable program read, jump to read_char_buf2
    beq $s4, 2, read_char_buf3                  #if it is the third variable program read, jump to read_char_buf3

read_char_buf1:
    li $v0, 8
    la $a0, char_buf1                           #read user input into char_buf1
    li $a1, 1024
    syscall

    lb $t6, ($a0)
    sb $t6, ($a0)
    addi $a0, $a0, 1                            #address+1

    lb $t6, ($a0)                               #load second byte, 
    bne $t6, '\n', if_not_char                  #if it is not '\n',means user do not enter char,jump to if_not_char
    sb $t6, ($a0)
    addi $a0, $a0, -1                           #address-1


    j is_char1

read_char_buf2:
    li $v0, 8
    la $a0, char_buf2                           #read user input into char_buf2
    li $a1, 1024
    syscall

    lb $t6, ($a0)
    sb $t6, ($a0)
    addi $a0, $a0, 1                            #address+1

    lb $t6, ($a0)                               #load second byte, 
    bne $t6, '\n', if_not_char                  #if it is not '\n',means user do not enter char,jump to if_not_char
    sb $t6, ($a0)
    addi $a0, $a0, -1                           #address-1

    j is_char2

read_char_buf3:
    li $v0, 8
    la $a0, char_buf3                           #read user input into char_buf3
    li $a1, 1024
    syscall

    lb $t6, ($a0)
    sb $t6, ($a0)
    addi $a0, $a0, 1                            #address+1

    lb $t6, ($a0)                               #load second byte, 
    bne $t6, '\n', if_not_char                  #if it is not '\n',means user do not enter char,jump to if_not_char
    sb $t6, ($a0)
    addi $a0, $a0, -1                           #address-1

    j is_char3

    

is_char1:
    lb $s7, ($a0)                               #load user input char to $s7
	j read_shift_args 

is_char2:
    lb $s7, ($a0)                               #load user input char to $s7
	j read_shift_args 

is_char3:
    lb $s7, ($a0)                               #load user input char to $s7
	j read_shift_args 


if_not_char:
    li $v0, 4
    la $a0, prompt6                             #if user do not enter char, print prompt6
    syscall
    
    move $s7, $0                                #clear $s7
    
    li $v0, 4
    la $a0, prompt4                             #print prompt4
    syscall

    j read_shift_args 

read_str_buf1:
    li $v0, 8
    la $a0, str_buf1                             #read user input into str_buf1
    li $a1, 1024
    syscall
    j read_str_store                            #jump to read_str_store

read_str_buf2:
    li $v0, 8
    la $a0, str_buf2                            #read user input into str_buf1
    li $a1, 1024
    syscall
    j read_str_store                            #jump to read_str_store

read_str_buf3:
    li $v0, 8
    la $a0, str_buf3                            #read user input into str_buf1
    li $a1, 1024
    syscall
    j read_str_store                            #jump to read_str_store

loadprompt1:
    la $a0, prompt1                             #if it is the first variables program meet, print prompt1
    j read_fmt

loadprompt2:
    la $a0, prompt2                             #if it is the second variables program meet, print prompt2
    j read_fmt

loadprompt3:
    la $a0, prompt3                             #if it is the third variables program meet, print prompt3
    j read_fmt

loadvar1:
    move $t1, $s7                               #if it is the first variables program read, store it in $t1
    j read_shift_args_final

loadvar2:
    move $t2, $s7                               #if it is the second variables program read, store it in $t2
    j read_shift_args_final

loadvar3:
    move $t3, $s7                               #if it is the third variables program read, store it in $t3
    j read_shift_args_final


read_end:
    move $a0, $t7                               #$t7 stores the orginal user input string, more to $a0
    move $a1, $t1                               #move first variables to $a1
    move $a2, $t2                               #move second variables to $a2
    move $a3, $t3                               #move third variables to $a3


    jal printf                                  #link printf part function


    j exit                                      #jump to exit



printf:
    subu  $sp, $sp, 36                          #set up stack frame
    sw $ra, 32($sp)                             #save local variables
    sw $fp, 28($sp) 
    sw $s0, 24($sp) 
    sw $s1, 20($sp) 
    sw $s2, 16($sp) 
    sw $s3, 12($sp) 
    sw $s4, 8($sp) 
    sw $s5, 4($sp) 
    sw $s6, 0($sp) 
    addu  $fp, $sp, 36 
                                                #grab the arguments
    move $s0, $a0                               # fmt string
    move $s1, $a1                               # arg1, optional
    move $s2, $a2                               # arg2, optional
    move $s3, $a3                               # arg3, optional

    li $s4, 0                                   # set the number of variables = 0
    la $s6, printf_buf                          # set s6 = base of buffer
    
    li $v0, 4
    la $a0, prompt5                             #printf prompt5
    syscall

printf_loop:
    lb $s5, 0($s0) 
    addu $s0, $s0, 1                            #address+1 
    beq $s5, '%', printf_fmt                    #meet '%' jump to printf_fmt 
    beq $0, $s5, printf_end                     # if zero, finish

printf_putc:
    sb $s5, 0($s6)
    sb $0, 1($s6) 
    move $a0, $s6                               #put char 
    li $v0, 4 
    syscall
    j  printf_loop 

printf_fmt:
    lb $s5, 0($s0)                              # get the char after '%'
    addu $s0, $s0, 1                            #address+1
    beq $s4,  3, printf_loop                    # check if already processed 3 args.

    beq $s5, 'd', printf_int                    # if 'd', then print as a decimal integer

    beq $s5, 's', printf_str                    # if 's', then print as a string

    beq $s5, 'c', printf_char                   # if 'c', then print as an ASCII char

    beq $s5, '%', printf_perc                   # if '%', then print as a '%'

    beq $s5, 'S', upper_loop                    # if 'S', jump to upper_loop

    j  printf_loop 

printf_shift_args:
    move $s1, $s2 
    move $s2, $s3                               #move variables to former place
    addi $s4, $s4, 1                            # increment no. of args processed
    j printf_loop

printf_int:                                     #print integer
    move $a0, $s1                               #print the value stored in $s1
    li $v0, 1 
    syscall 
    j printf_shift_args 

printf_str:                                     #print string
	move $a0, $s1                               #move string to $a0
	li $v0, 4
    syscall
	j printf_shift_args 

printf_char:                                    #print ASCII char
	sb $s1, 0($s6)                      
	sb $0, 1($s6)                               #move char and 0 into printf_buf
	move $a0, $s6                               #move char to $a0
	li $v0, 4
    syscall
	j printf_shift_args 

printf_perc:                                    #print '%'
	li $s5, '%'
	sb $s5, 0($s6)
	sb $0, 1($s6)                               #move '%' and 0 into printf_buf
	move $a0, $s6                               #move '%'to $a0
	li $v0, 4
	syscall
	j printf_shift_args 

upper_loop:
    lb $t5, ($s1)                               #load byte
    beq $t5, 0,printf_shift_args                #if byte is empty, jump to printf_shift_args 
    blt $t5, 'a',printf_upper
    bgt $t5, 'z', printf_upper                  # if it is not lower character, jump to printf_upper
    sub $t5, $t5, 32                            #if the ASCII is between the ASCII of 'a' and 'z', ASCII -32
    sb $t5, ($s1)

printf_upper:
    sb $t5, 0($s6)
    sb $0, 1($s6) 
    move $a0, $s6                               #printf the character in upper
    li $v0, 4 
    syscall

nochange:
    addi $s1,$s1,1                             #address+1, ready for read next character
    j upper_loop


printf_end:
    
    lw $ra, 32($sp) 
    lw $fp, 28($sp) 
    lw $s0, 24($sp)
    lw $s1, 20($sp) 
    lw $s2, 16($sp) 
    lw $s3, 12($sp) 
    lw $s4, 8($sp) 
    lw $s5, 4($sp) 
    lw $s6, 0($sp) 
    addu $sp, $sp, 36 
    jr $ra 
 
exit:
    li $v0, 10                                  #exit
    syscall 
