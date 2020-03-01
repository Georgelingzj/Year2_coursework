// Zijian Ling
//This function calculates integer z =log x.And x is positive integers
//the base of logatithm is 2
//z is round down to nearest integer
//x,z are stored in RAM[0],RAM[2],respectively
//Breif idea:the base of multiply is 1,first double multiply,then x-multiply
//to see if (x-multiply) is greater than multiply,if it is,z++.otherwise,finish function
//NOTICE: all comments are written ABOVE line code

//Variable initialization
//RESULT used to temporary store result
@RESULT
M=0
//the base of multiplication
@MULTIPLY
M=1

(LOOP)
//TEMP used to store the value of MULTIPLY
@TEMP
M=0
@MULTIPLY
D=M
@TEMP
M=D
@TEMP
D=M
//double the MULTIPLY
@MULTIPLY
D=D+M
@MULTIPLY
M=D
//RESULT+1
@6
M=1
@6
D=M
@RESULT
D=D+M
@RESULT
M=D
//if (x-MULTIPLY)-x>0,do next loop.otherwise,break
@0
D=M
@MULTIPLY
D=D-M
//DIFF = x-MULTIPLY
@DIFF
M=D
@MULTIPLY
D=M
@DIFF
D=M-D
//jump to assgin function
@ASSIGN
D;JLT
//condition satisfied,continue loop
@LOOP
0;JMP

(ASSIGN)
//RAM[2] = RESULT
@RESULT
D=M
@2
M=D

(END)
@END
0;JMP