// Zijian Ling
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <math.h>
#include <ctype.h>
#define COL 82               //column number include two border of the map
#define ROW 42               //row number include two border of the map
#define DUPLICATED_RANGE 0.1 //if less, two target is duplicated

const int EXIT_MALLOC_FAILURE = -1;
const int EXIT_OTHER_FAILURE = -2;

struct list
{
    char position_name[20];
    double value_latitude;
    double value_longitude;
    struct list *link;
};

typedef struct list List_t;
char *MAP_2D[ROW][COL]; //BASIC BASIC MAP
char i[2] = "\n";       //determine if the user pressea enter without any character
char press_enter[5];    //to store '\n',when user enter 3,because fgets will read the '\n'after '3'

void memory_check(int parameter);
char *prompt(const char *mesg);
void menu_print();
void load_targer_file(List_t *pointer);
void list_print(List_t *pointer);
void list_free(List_t *pointer);
int isEmpty(List_t *pointer);
void list_append(List_t *pointer, char *name, double latitude, double longtitude);
double distence_calculator(double latitude_inlist, double longitude_inlist, double latitude_new, double longtitude_new);
int list_contain(List_t *pointer, double latitude, double longitude, double radius_range);
void show_target(List_t *pointer, char *MAP[ROW][COL]);
void target_search(List_t *pointer);
void airstrike_target_show(List_t *pointer);
void airstrike_execute(List_t *pointer);

int main()
{
    //linked list to store target from valid file
    List_t *start, *temp;
    start = (List_t *)malloc(sizeof(List_t));
    memory_check(start == NULL); //check whether can allocate memory
    temp = start;
    temp->link = NULL;

    menu_print(); //print menu
    int option = 0;
    char input_buffer[50];
    char rubbish_buffer[2]; //to store \n
    fgets(input_buffer, 50, stdin);
    option = atoi(input_buffer); //get option from user

    while (1)
    {

        if (option >= 1 && option <= 6)
        {
            if (option == 1)
            {
                load_targer_file(start); //load file
            }
            if (option == 2)
            {
                int is_valid = isEmpty(start);
                if (is_valid == 1)
                {
                    list_print(start);
                    show_target(start, MAP_2D); //print map
                }
            }
            if (option == 3)
            {
                target_search(start);
                fgets(press_enter, 1, stdin); //to store the newline character '\n'
                puts(" ");
            }
            if (option == 4)
            {
                airstrike_target_show(start);
                fgets(rubbish_buffer, 2, stdin); //to store newline character '\n'
            }
            if (option == 5)
            {
                airstrike_execute(start);
                fgets(rubbish_buffer, 2, stdin); //to store newline character'\n'
                puts(" ");
            }
            if (option == 6)
            {
                list_free(start); //free all memory
                exit(0);          //normal exit
            }
            printf("Option: ");
        }
        else
        {
            printf("Unknow option\n");
            printf("Option: ");
        }

        fgets(input_buffer, 50, stdin);
        option = atoi(input_buffer); //get option from user
    }
    return 0;
}

//check whether can allocate memory
void memory_check(int parameter)
{
    if (parameter)
    {
        perror("Unable to allocate memory.\n");
        exit(EXIT_MALLOC_FAILURE);
    }
}

//print list
void menu_print()
{
    //print the menu
    puts(" ");
    puts("1)Load a target file");
    puts("2)Show current target");
    puts("3)Search a target");
    puts("4)Plan an airstrike");
    puts("5)Execute an airstrike");
    puts("6)Quit");
    printf("Option: ");
    return;
}

// prompt function from lecture(Dynamic Memory Allocation)
//https://moodle.nottingham.ac.uk/pluginfile.php/6105260/mod_resource/content/1/dynamic.c?forcedownload=1

char *prompt(const char *mesg)
{
    // print the prompt
    if (mesg != NULL)
    {
        printf("%s", mesg);
    }

    int buffer_size = 8; // buffer size, includes terminator.
    int bidx = 0;        // index to store next character

    char *buffer = malloc(sizeof(char) * buffer_size); // allocate the starting buffer size
    memory_check(buffer == NULL);
    if (buffer == NULL)
    {
        return NULL;
    }
    // read in a character at a time
    do
    {
        char tmp = '\0';
        scanf("%c", &tmp);

        if (tmp == '\n')
        {
            // Pressed return
            buffer[bidx] = '\0'; // Add nul byte at current location
            return buffer;
        }
        else
        {
            buffer[bidx] = tmp; // Pressed a different key
            bidx++;

            if (bidx == buffer_size)
            {
                char *newbuf = realloc(buffer, sizeof(char) * (buffer_size * 2));
                memory_check(newbuf == NULL);

                if (newbuf == NULL)
                {
                    free(buffer); // realloc doesn't automatically free，original buffer on error
                    return NULL;
                }
                else
                {
                    buffer = newbuf;
                    buffer_size = buffer_size * 2;
                }
            }
        }
    } while (1); // loop forever

    return NULL;
}

//load target file
//first judge if the file is valid, if valid then load ,otherwise return
void load_targer_file(List_t *pointer)
{
    char *message = prompt("Enter a target file: ");
    int len = strlen(message);
    char filename[len];
    strcpy(filename, message); //get file name
    free(message);

    FILE *fp;
    int file_valid = 1; //if file_valid = 1, file is valid.Otherwise, invalid

    if ((fp = fopen(filename, "r")) == NULL)
    {
        puts("Invalid file\n");
        return; //unalbe to open file
    }
    else
    {
        char name[100];
        double value1 = 0.0;
        double value2 = 0.0;
        char value1_str[100];
        char value2_str[100];

        while (!feof(fp))
        {
            fscanf(fp, "%s %s %s", name, value1_str, value2_str); //read from file
            value1 = atof(value1_str);                            //string to double
            value2 = atof(value2_str);

            int j = 0;                                //to go through
            for (j = 0; j < ((int)strlen(name)); j++) //
            {
                if ((isalnum(name[j])) == 0)
                {
                    file_valid = 0; //name can only contain english characters and digits
                }
            }

            for (j = 0; j < (int)strlen(value1_str); j++)
            {
                if (value1_str[j] != '.')
                {
                    if (isdigit(value1_str[j]) == 0)
                    {
                        file_valid = 0; //latitude only contain '.' and digits
                    }
                }
            }

            for (j = 0; j < (int)strlen(value2_str); j++)
            {
                if (value2_str[j] != '.')
                {
                    if (isdigit(value2_str[j]) == 0)
                    {
                        file_valid = 0; //longtitude only contain '.' and digits
                    }
                }
            }

            if (strlen(value1_str) > 15 || strlen(value2_str) > 15 || strlen(name) > 15 || value1 < 0.0 || value2 < 0.0 || value1 > 100.0 || value2 > 100.0)
            {
                file_valid = 0; //if length greater than 15 or latitude and longtitude is out of [0,100], the file is invalid
            }
        }
        fclose(fp);
    }

    //load target
    if (file_valid == 1)
    {
        FILE *fp1;

        fp1 = fopen(filename, "r");
        char name[20];
        double value1 = 0.0; //store latitude
        double value2 = 0.0; //store longtitude

        while (!feof(fp1))
        {
            fscanf(fp1, "%s %lf %lf", name, &value1, &value2);                      //read from file
            int is_valid = list_contain(pointer, value1, value2, DUPLICATED_RANGE); //judge if dupicated target(distance<0.1)
            if (is_valid == 1)                                                      //if not duplicated
            {
                list_append(pointer, name, value1, value2); // add target to linked list
            }
        }
        fclose(fp1);
    }
    else
    {
        puts("Invalid file\n");
    }
}

//add target to linked list
void list_append(List_t *pointer, char *name, double latitude, double longtitude)
{
    while (pointer->link != NULL)
    {
        pointer = pointer->link;
    }
    pointer->link = (List_t *)malloc(sizeof(List_t));
    memory_check(pointer->link == NULL);

    pointer = pointer->link;
    strcpy(pointer->position_name, name);
    pointer->value_latitude = latitude;
    pointer->value_longitude = longtitude;
    pointer->link = NULL;
}

//print Linked list
void list_print(List_t *pointer)
{
    List_t *cur = pointer->link;
    while (cur != NULL)
    {
        printf("%s %lf %lf\n", cur->position_name, cur->value_latitude, cur->value_longitude);
        cur = cur->link;
    }
    puts(" ");
}

//free linked list
void list_free(List_t *pointer)
{
    if (pointer->link == NULL)
    {
        return;
    }
    else
    {
        while (pointer->link != NULL)
        {
            List_t *n = pointer->link;
            pointer->link = n->link;
            free(n);
        }
        return;
    }
}

//calculate the distence between two target
double distence_calculator(double latitude_inlist, double longitude_inlist, double latitude_new, double longtitude_new)
{
    if (latitude_new > 100.0 || latitude_new < 0.0 || longtitude_new > 100.0 || longtitude_new < 0.0) //reject invalid latitude and longtitude
    {
        return 0;
    }
    else
    {
        double distence = sqrt((double)pow(latitude_inlist - latitude_new, 2) + (double)pow(longitude_inlist - longtitude_new, 2));
        return distence; //distence = length of straight line segment from two pointe
    }
}

//check if linked list has contain duplicated target
int list_contain(List_t *pointer, double latitude_new, double longitude_new, double radius_range)
{
    if (pointer->link == NULL)
    {
        return 1;
    }
    else
    {
        pointer = pointer->link;
        while (pointer != NULL)
        {
            double distence = distence_calculator(pointer->value_latitude, pointer->value_longitude, latitude_new, longitude_new);

            if (distence <= radius_range)
            {
                return 0;
            }
            else
            {
                pointer = pointer->link;
            }
        }
        return 1;
    }
    puts(" ");
}

//judge if a linked list is empty
int isEmpty(List_t *pointer)
{
    int isEmpty = 1;
    if (pointer->link == NULL)
    {
        isEmpty = 0;
    }
    return isEmpty;
}

//show current target stored in linked list
void show_target(List_t *pointer, char *MAP[ROW][COL])
{
    int row = 0, col = 0;
    for (row = 0; row <= ROW - 1; row++)
    {
        for (col = 0; col <= COL - 1; col++)
        {

            if (col == 0 || row == 0 || col == COL - 1 || row == ROW - 1)
            {
                MAP[row][col] = "#"; //the border of map is "#"
            }
            else
            {
                MAP[row][col] = " "; //no target shows " "
            }
        }
    }
    //load target to map
    if (pointer->link == NULL)
    {
        return;
    }
    else
    {
        printf("the 80*40(width*height) 2D map is below\n\n");
        printf("the value of lontitude correspond to width value, the value of latitude correspond to height value\n\n");
        printf("Width\theight\n");
        pointer = pointer->link; //get to the first node of linked list
        while (pointer != NULL)
        {
            //transform the coordinate from[0,100] to [1,80],
            int value_row = (floor((pointer->value_latitude) * (40.0 / 101.0))) + 1;  //latitude(new) = latitude(old)*(40/101)
            int value_col = (floor((pointer->value_longitude) * (80.0 / 101.0))) + 1; //longtitude(new) = longtitude*(80/101)
            printf("%d\t%d\n", value_col, value_row);
            MAP[value_row][value_col] = "@"; //target uses "@"
            pointer = pointer->link;
        }
        //print the 2D-map
        puts(" ");
        for (row = 0; row <= ROW - 1; row++)
        {
            for (col = 0; col <= COL - 1; col++)
            {
                printf("%s", MAP[row][col]);
                if (col == COL - 1)
                {
                    printf("\n");
                }
            }
        }
    }
    printf("finish print\n");
}

//seach target in linked list
void target_search(List_t *pointer)
{
    int isFound = 0; //if not find, isFound = 0.Otherwise, set it to 1.

    char *message = prompt("enter the name: ");
    int len = strlen(message);
    char search_name[len];
    strcpy(search_name, message); //read input search name
    free(message);

    //if the length of input target name is longer than 15, print erroe meg and exit(-2)
    if (strlen(search_name) > 16)
    {
        printf("Invalid targer name input\n");
        exit(EXIT_OTHER_FAILURE);
    }

    int k = isalnum(search_name[0]);
    if (k == 0)
    {
        return; //if user just press "enter", return
    }
    else
    {
        if (pointer->link == NULL)
        {
            printf("Entry does not exist\n");
            return; //empty linked list, return
        }
        else
        {
            pointer = pointer->link;
            while (pointer != NULL)
            {
                int compare = strcmp(search_name, pointer->position_name);
                if (compare == 0)
                {
                    printf("%s %lf %lf\n", pointer->position_name, pointer->value_latitude, pointer->value_longitude);
                    pointer = pointer->link;
                    isFound = 1;
                }
                else
                {
                    pointer = pointer->link; //nest node in linked list
                }
            }
        }
        if (isFound == 0)
        {
            printf("Entry does not exist\n"); //not find
        }
        return;
    }
}

//show target in collision range
void airstrike_target_show(List_t *pointer)
{
    //define some local variable
    double latitude_pre = 0, longtitude_pre = 0;
    double radius_pre = 0;
    char latitude_str[100];
    char longtitude_str[100];
    char radius_str[100];
    //read user input using as string
    printf("Enter predicted latitude: ");
    scanf("%s", latitude_str);
    printf("Enter predicted longtitude: ");
    scanf("%s", longtitude_str);
    printf("Enter radius of damage zone: ");
    scanf("%s", radius_str);

    if (strlen(latitude_str) > 15 || strlen(longtitude_str) > 15)
    {
        printf("Invalid latitude or longtitude input\n"); //too long variable
        exit(EXIT_OTHER_FAILURE);
    }
    else
    {
        int k = 0; //for go through latitude_str, longtitude_str and radius_str
        for (k = 0; k < strlen(latitude_str); k++)
        {
            if (latitude_str[k] != '.')
            {
                if (isdigit(latitude_str[k]) == 0)
                {
                    printf("Invalid latitude or longtitude input\n"); //latitude contain nondigit-character
                    exit(EXIT_OTHER_FAILURE);
                }
            }
        }
        for (k = 0; k < strlen(longtitude_str); k++)
        {
            if (longtitude_str[k] != '.')
            {
                if (isdigit(longtitude_str[k]) == 0)
                {
                    printf("Invalid latitude or longtitude input\n"); //longtitude contain nondigit-character
                    exit(EXIT_OTHER_FAILURE);
                }
            }
        }
        for (k = 0; k < strlen(radius_str); k++)
        {
            if (radius_str[k] != '.')
            {
                if (isdigit(radius_str[k]) == 0)
                {
                    printf("Invalid radius input\n"); //radius contain nondigit-character
                    exit(EXIT_OTHER_FAILURE);
                }
            }
        }
    }
    //string to double
    latitude_pre = atof(latitude_str);
    longtitude_pre = atof(longtitude_str);
    radius_pre = atof(radius_str);

    if (pointer->link == NULL)
    {
        return; //empty linked list
    }
    else
    {
        pointer = pointer->link;
        while (pointer != NULL)
        {
            double distence = distence_calculator(pointer->value_latitude, pointer->value_longitude, latitude_pre, longtitude_pre);

            if (distence <= radius_pre) //tatget in range
            {
                printf("%s %lf %lf\n", pointer->position_name, pointer->value_latitude, pointer->value_longitude); //print target in range
            }
            pointer = pointer->link;
        }
        return;
    }
}

//show target in collisuon range and delete them in orginal linked list
void airstrike_execute(List_t *pointer)
{
    //define some local variable
    int destoryed_num = 0;                       //counter how many target have been destroyed
    double latitude_pre = 0, longtitude_pre = 0; //to store the latitude and longtitude of target collision point
    double radius_pre = 0;                       //to store the radius of damage zone
    char latitude_str[100];
    char longtitude_str[100];
    char radius_str[100];

    //creat a new linked list to store those in damage zone, and delete them in orginal linked list
    List_t *new_start, *new_temp;
    new_start = (List_t *)malloc(sizeof(List_t));
    memory_check(new_start == NULL); //memory check
    new_temp = new_start;
    new_temp->link = NULL; //create a new linked list to store target in range

    printf("Enter predicted latitude: "); //user input begin
    scanf("%s", latitude_str);
    printf("Enter predicted longtitude: ");
    scanf("%s", longtitude_str);
    printf("Enter radius of damage zone: ");
    scanf("%s", radius_str);

    if (strlen(latitude_str) > 15 || strlen(longtitude_str) > 15)
    {
        printf("Invalid latitude or longtitude input\n"); //too long input
        exit(EXIT_OTHER_FAILURE);
    }
    else
    {
        int k = 0; //for go through latitude_str, longtitude_str and radius_str
        for (k = 0; k < strlen(latitude_str); k++)
        {
            if (latitude_str[k] != '.')
            {
                if (isdigit(latitude_str[k]) == 0)
                {
                    printf("Invalid latitude or longtitude input\n"); //latitude contain nondigit-character
                    exit(EXIT_OTHER_FAILURE);
                }
            }
        }
        for (k = 0; k < strlen(longtitude_str); k++)
        {
            if (longtitude_str[k] != '.')
            {
                if (isdigit(longtitude_str[k]) == 0)
                {
                    printf("Invalid latitude or longtitude input\n"); //longtitude contain nondigit-character
                    exit(EXIT_OTHER_FAILURE);
                }
            }
        }
        for (k = 0; k < strlen(radius_str); k++)
        {
            if (radius_str[k] != '.')
            {
                if (isdigit(radius_str[k]) == 0)
                {
                    printf("Invalid radius input\n"); //radius contain nondigit-character
                    exit(EXIT_OTHER_FAILURE);
                }
            }
        }
    }
    //string to double
    latitude_pre = atof(latitude_str);
    longtitude_pre = atof(longtitude_str);
    radius_pre = atof(radius_str);

    if (pointer->link == NULL)
    {
        printf("No target stored in linked list\n"); //indicate empty linked list
        return;
    }
    else
    {
        while (pointer->link != NULL)
        {
            double distance = distence_calculator((pointer->link)->value_latitude, (pointer->link)->value_longitude, latitude_pre, longtitude_pre);
            if (distance <= radius_pre) //if the target is inside the damange range
            {
                list_append(new_start, (pointer->link)->position_name, (pointer->link)->value_latitude, (pointer->link)->value_longitude); //store node in new linked list
                //delete target from orginal list
                List_t *temp;
                temp = pointer->link;
                pointer->link = temp->link;
                free(temp);
                destoryed_num++; //number of destoryed targer plus one
            }
            else
            {
                pointer = pointer->link;
            }
        }
    }
    if (destoryed_num == 0)
    {
        printf("No target aimed. Mission cancelled.\n");
        list_free(new_start);
    }
    else
    {
        printf("%d target destroyed\n", destoryed_num);
        list_print(new_start);
        list_free(new_start); //free new linked list
    }
    return;
}