#  Zijian Ling

#int fibonacci(int n) in recursive way
#if input == 0, output 0
#else  the output will be number in n position in fibonacci sequence
#This program can handle positive integer, negative integer, char_or_string, float_number and overflow
#All abnormal cases list above all have prompt to remind user

#Sample input and output are in the fibonacci.txt attached

#NOTICE: all comments are written AFTER or ABOVE the line code


.data
prompt1:	.asciiz "Please enter a positive integer: \n"
prompt2:	.asciiz "The result is: \n"
prompt3:    .asciiz "Error, you have enter a negative integer!\n"
prompt4:    .asciiz "this is a character or string!\n"
prompt5:    .asciiz "this is a float number!\n"
prompt6:    .asciiz "You have entered 0, the result is 0\n"
prompt7:    .asciiz "Input number greater than 46, the result will overflow!\n"
buffer:     .space 1024


.text
.globl main

main:
    li $v0, 4                           #print prompt1
    la $a0, prompt1              
    syscall

    li $v0, 8                           #use buffer to read user input
    la $a0, buffer                      #store address in $a0
    li $a1, 1024                        #limited length by 1024
    syscall 

    la $s0,buffer                       #load input address to $s0

    lb $t0, ($s0)                       #load the first byte of $s0

    beq $t0, 45, lessThenzero           #if the first byte is '-', it is negative,jump to lessThenzero
    bgt $t0, 57, char_or_string         #if the ASCII of $t0 greater than 57 or less than 48
    blt $t0, 48, char_or_string         #it is char or string, than jump to char_or_string

    sb $t0, ($s0)                       #save byte

    #detect Floating point with only one digit before the decimal point
    addi $s0, $s0, 1                    #address+1
    
    lb $t1, ($s0)                       #load second byte

    beq $t1, 46, float_number           #the ASCII of '.' is 46

    sb $t1, ($s0)                       #save byte

    #detect Floating point with only two digits before the decimal point
    #basecase user's input must less or equal than 46, so detect two digits before decimal point is enough
    
    addi $s0, $s0, 1                    #address+1
    
    lb $t1, ($s0)                       #load second byte

    beq $t1, 46, float_number           #the ASCII of '.' is 46

    sb $t1, ($s0)                       #save byte

    addi $s0, $s0, -2                   #back the address to beginning

    j integer_read                      #Only user input is a valid positive integer,jump to integer_read


integer_read:

    la $a0, ($s0)                       #load address of user input to $a0
    jal strlen                          #counter the length of user input

    move $s6, $a0                       
    addi $s6, $s6, -1                   #basecase strlen function have read '\n' in user input
  
    la $a0, buffer                      #load user input to $a0
    jal string_to_integer               #transform string to integer

    move $s1, $a0                       #detect overflow
    bgt $s1, 46, overflow               #user input >46 will overflow
    beq $s1, 0 ,equalTozero             #if user input == 0, jump to equalTozero
    move $a0, $s1

    jal fibonacci                       #jump and link fibonacci function

    move $a1, $v0                       #the value calculated by fibonacci is passed by $v0

    li $v0, 4
    la $a0, prompt2                     #print prompt2
    syscall

    li $v0, 1
    move $a0, $a1                       #print the result
    syscall

    j exit                              #jump to exit


strlen:
	li $t0, 0                           #$t0 to store the length of user input
	la $a0, buffer                      #load the address of user input to $a0

strlen_loop:
	lb $t1, ($a0)                       
	bne $t1, $0, strlen_next            #if the byte is not empty than go to strlen_next
    sb $t1, ($a0)                       #if there is no byte remaining
	move $a0, $t0                       #move $t0, to $a0 
	jr $ra                              #jump back to function return address

strlen_next:
	addi $a0, $a0, 1                    #address +1
	addi $t0, $t0, 1                    #length +1
	j strlen_loop                       #jump to strlen_loop to read next byte


string_to_integer:                      #function that transform string to integer       
    la $a0, buffer                      #load user input
    li $t6, 1                           #store the result of multiplication below
    li $s2, 0                           # store integer value
   
    
Loop_detect:
    bne $s6, $0, Loop_next              #if the length of integer != 0, go to next Loop
    move $a0, $s2                       #otherwise, move integer to $a0
    jr $ra                              #jump to return address

Loop_next:
    lb $t5, ($a0)                       #load byte
    addi $t5, $t5, -48                  #subtract its ASCII by 48, get integer itself
    
    beq $s6, 3, mul3                    #Three digits integer, jump to mul3

    beq $s6, 2, mul2                    #two digit integer, jump to mul2

    beq $s6, 1, mul1                    #one digit integer, jump to mul1

#Simple explanation: integer have three digit format like xyz, when transform string to integer, it equals to 100*x+10*y+1*z    
mul3:
    li $t4, 100                         #$t4 = 100
    mul $t6, $t5, $t4                   #digit*100
    add $s2, $s2, $t6                   #add digit*100 $s6
    addi $s6, $s6,-1                    #length of digit-1
    addi $a0, $a0, 1                    #address+1
    j Loop_detect                       

mul2:
    li $t4, 10                          #$t4 = 10
    mul $t6, $t5, $t4                   #digit*10
    add $s2, $s2, $t6                   #add digit*100 $s6
    addi $s6, $s6,-1                    #length of digit-1
    addi $a0, $a0, 1                    #address+1
    j Loop_detect

mul1:
    li $t4, 1                           #$t4 = 1                           
    mul $t6, $t5, $t4                   #digit*1                                
    add $s2, $s2, $t6                   #add digit*100 $s6
    addi $s6, $s6,-1                    #length of digit-1
    addi $a0, $a0, 1                    #address+1
    j Loop_detect



#int fibonacci(int n)
#the input is n(the position in sequence)
#the output is the value in fibonacci sequence whose position number is n
fibonacci:
    addi $sp, $sp, -12                  #set up stack frame
    sw $ra, 8($sp)
    sw $s1, 4($sp)      
    sw $s2, 0($sp)
   
    move $s1, $a0                       #pass input n to $s1

    li $v0, 1                           #return value when reach the basecase
 
    ble $s1, 2, fibonacci_end           #basecase is when f(n-1) == f(2),if reach basecase,jump to "fiboExit"
   
    addi $a0, $s1, -1                   #n-1
   
    jal fibonacci                       #recursive call fibonacci(n-1)
   
    move $s2, $v0                       #store fibonacci(n-1) in $s2
        
    addi $a0, $s1, -2                   #n-2
        
    jal fibonacci                       #recursive call fibonacci(n-2)
    
    add $v0, $s2, $v0                   #$v0 = fibonacci(n-1) + fibonacci(n-2)


#end of fibonacci function
fibonacci_end:
    lw $ra, 8($sp)                     #restore return address
    lw $s1, 4($sp)              
    lw $s2, 0($sp)
    addi $sp, $sp, 12                  #restore stack pointer
    jr $ra                             #return to main



float_number:
    li $v0, 4
    la $a0, prompt5                    #if float_number, print prompt5
    syscall
    j exit

char_or_string:                        #if string_to_integer, print prompt4
    li $v0, 4
    la $a0, prompt4
    syscall

    j exit


equalTozero:
    li $v0, 4
    la $a0,prompt6                    #if user input == 0, print prompt6
    syscall
        
    j  exit                     


lessThenzero:

    li $v0, 4
    la $a0, prompt3                 #if user input<0, print prompt3
    syscall

    j exit


overflow:
    li $v0, 4
    la $a0, prompt7                 #if user input>46, print prompt7               
    syscall


exit:
    li $v0, 10                       #exit
    syscall