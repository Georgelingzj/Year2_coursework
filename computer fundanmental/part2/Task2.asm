// Zijian Ling
//This function calculates integer z = x^y.And x,y,z are non-negative integers
//x,y,z are stored in RAM[0],RAM[1],RAM[2],respectively
//RAM[2] = RAM[3]=0,if x = y = 0.Otherwise,RAM[3]=1
//Breif idea:have a big loop1 to calculates x*x for (y-1)times
//also have a small loop2 to calculates x+x for (x-1)times
//NOTICE: all comments are written ABOVE line code

//Variable initialization
//COUNTER counters times that do x*x
@1
D=M
@COUNTER
M=D
//MULTIPLY temporary store the result
@MULTIPLY
M=1
//used to set RAM[3]
@TWO_ZREO_COUNTER
M=0

//to judge if either x or y equal to 0
(ZERODECTECT0)
@0
D=M
//jump to sub function
@FIRSTNUMBERZERO
D;JEQ

//to judge whether x is 1
(ONEDECTECT)
@6
M=1
@6
D=M
@0
D=M-D
//jump to sub function
@FIRSTNUMBERONE
D;JEQ

//big loop1:do x*x when y>0,then y--,if y==0,break
(LOOPONE)
//if COUNTER>0,do x*x
@COUNTER
D=M
@ASSIGN
D;JEQ
//COUNTER--
@6
M=1
@6
D=M
@COUNTER
D=M-D
@COUNTER
M=D
//TEMP store result
@TEMP
M=0
@MULTIPLY
D=M
@TEMP
M=D
//when do x*x,it is actually x plus itself for (x-1) times
//use I to be the counter in small loop below
@0
D=M
@I
M=D
@7
M=-1
@7
D=M
@I
D=D+M
@I
M=D

//small loop2,x plus itself for (x-1) times
(LOOPTWO)
//do x+x one time
@TEMP
D=M
@MULTIPLY
D=D+M
@MULTIPLY
M=D
//I = I-1
@7
M=-1
@7
D=M
@I
D=D+M
@I
M=D
@I
D=M
//if I>0,do loop2,otherwise,back to loop1
@LOOPONE
D;JLE
@LOOPTWO
0;JMP

(FIRSTNUMBERZERO)
@MULTIPLY
M=0
@TWO_ZREO_COUNTER
M=1
//judge whether y is 0
@1
D=M
@ASSIGN
D;JNE
//if x==0,then judge whether y == 0
@1
D=A
@TWO_ZREO_COUNTER
M=M+D
@ASSIGN
0;JMP

//if x ==0,result is always 1
(FIRSTNUMBERONE)
@MULTIPLY
M=1
@ASSIGN
0;JMP


(ASSIGN)
//RAM[2] = MULTIPLY
@MULTIPLY
D=M
@2
M=D
//set RAM[3] = 1
@3
M=1
//do TWO_ZREO_COUNTER-1
@1
D=A
@TWO_ZREO_COUNTER
M=M-D
@TWO_ZREO_COUNTER
D=M
//if x=y=0,TWO_ZREO_COUNTER -1=1>0,then RAM[2]=RAM[3]=-1
@END
D;JLE
@3
M=-1
@2
M=-1

(END)
@END
0;JMP


