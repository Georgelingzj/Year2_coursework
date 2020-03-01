// Zijian Ling
//This function calculates integer z = x/y.And x,y,z are integers
//z is round off
//x,y,z are stored in RAM[0],RAM[1],RAM[2],respectively
//RAM[2] = RAM[3]=0,ify==0.Otherwise,RAM[3]=1
//breif idea has been written between line code
//NOTICE: all comments are written ABOVE line code

@COUNTER
M=0
//temporary store quotient
@QUOTIENT
M=0
@DOUBLE
M=0

//one of x or y less than 0,SYMBOLDECTECT++
//SYMBOLDECTECT=0||2,the result is positive.otherwise,negative
@SYMBOLDECTECT
M=0
@REDUCTIONINDECATE0
M=0
@REDUCTIONINDECATE1
M=0
//if x<0,make x = |x|
(FIRSTDECTECT)
@0
D=M
@FIRSTLESSTHANZERO
D;JLT

(SECONDDECTECT)
@1
D=M
//if y<0,make y=|y|
@SECONDLESSTHANZERO
D;JLT
//if y=0, skip all calculated parts
@SECONDEQUALTOZERO
D;JEQ

//if x and y have same sign, and if x is half of y, z should be 1
(HALFDECTECT)
//double x
@0
D=M
@HALF
M=D
@0
D=M
@HALF
D=D+M
@HALF
M=D
//compare 2x and y
@1
D=M
@HALF
D=D-M
@LOOP
D;JNE
//if 2x == y,z=1
@5
M=1
@5
D=M
@QUOTIENT
M=D
//if x and y have different sign, and if x is half of y, z should be 0
@SYMBOLDECTECT
D=M
@SYMBOLDECTECT_COPY
M=D
@7
M=-1
@7
D=M
@SYMBOLDECTECT_COPY
D=M+D
@SYMBOLDECTECT_COPY
M=D
@SYMBOLDECTECT_COPY
D=M
//if SYMBOLDECTECT_COPY = 0 or 2,after -1,it cannot be 0
//only if one of x and y is negative,SYMBOLDECTECT_COPY = 1,it will be 0
@LOOP
D;JNE
@5
M=0
@5
D=M
//let result == 0(ex. -5/10 = 0)
@QUOTIENT
M=D
@STOP
0;JMP

//based on decice if 2*(x-DECIDE)>y,quotient+1,DECIDE=DECIDE+y,do next loop
//if 2*(x-DECIDE)<y,finish
(LOOP)
@DECIDE
M=0
@FINALDECIDE
M=0
//DECIDE = (y-DECIDE)*2
@0
D=M
@COUNTER
D=D-M
@DECIDE
M=D
@DECIDE
D=M
@DOUBLE
M=D
@DOUBLE
D=M
@DECIDE
D=D+M
@DECIDE
M=D
//compare DECIDE and y
@1
D=M
@DECIDE
D=M-D
@FINALDECIDE
M=D
@STOP
D;JLE
//QUOTIENT+1
@QUOTIENT
M=M+1
@1
D=M
@COUNTER
D=D+M
@COUNTER
M=D
//COUNTER+Y
@LOOP
0;JMP

(STOP)
@QUOTIENT
D=M
//RAM[2]=QUOTIENT
@2
M=D
//RAM[3]=1,valid
@3
M=1
@SYMBOL
0;JMP



(FIRSTLESSTHANZERO)
//store 0
@5
M=0
@5
D=M
//if x<0,|x| = 0-x
@0
D=D-M
@0
M=D
@6
M=1
@6
D=M
//
@SYMBOLDECTECT
M=D
//if x<0,REDUCTIONINDECATE0=1.0,otherwise.This will used in reduction of x
@REDUCTIONINDECATE0
M=1
@SECONDDECTECT
0;JMP

(SECONDLESSTHANZERO)
//RAM[5] = 0
@5
M=0
@5
D=M
//if y<0,|y| = 0-y
@1
D=D-M
@1
M=D
//RAM[6] = 1
@6
M=1
@6
D=M
//SYMBOLDECTECT+1
@SYMBOLDECTECT
D=D+M
@SYMBOLDECTECT
M=D
//REDUCTIONINDECATE1+1, indicate when finish calculation, y will be back to negative
@REDUCTIONINDECATE1
M=1
@HALFDECTECT
0;JMP


(SECONDEQUALTOZERO)
//set RAM[3] = -1
@3
M=-1
//set RAM[2] = -1
@2
M=-1
@REDUCTION0
0;JMP

(SYMBOL)
//do SYMBOLDECTECT-1
@7
M=-1
@7
D=M
@SYMBOLDECTECT
D=M+D
@SYMBOLDECTECT
M=D
@SYMBOLDECTECT
D=M
//if SYMBOLDECTECT = 0 or 2,after -1,it cannot be 0
//only if one of x and y is negative,SYMBOLDECTECT = 1,it will be 0
@REDUCTION0
D;JNE
@5
M=0
@5
D=M
@2
D=D-M
@2
M=D

(REDUCTION0)
//if x is negative,after calculation,change it back to negative
@REDUCTIONINDECATE0
D=M
@REDUCTION1
D;JEQ
@STORE0
M=0
@0
D=M
@STORE0
D=M-D
@0
M=D

(REDUCTION1)
//if y is negative,after calculation,change it back to negative
@REDUCTIONINDECATE1
D=M
@END
D;JEQ
@STORE1
M=0
@1
D=M
@STORE1
D=M-D
@1
M=D

//end of the program
(END)
@END
0;JMP