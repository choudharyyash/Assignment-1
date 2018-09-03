
/* credit @Daniel Scocco */

/****************** CLIENT CODE ****************/

#include <stdio.h>
#include <sys/socket.h>
#include <netinet/in.h>
#include <string.h>
#include <arpa/inet.h>

int main(){
printf("fine");
  int clientSocket;
  char buffer[1024];
  struct sockaddr_in serverAddr;
  socklen_t addr_size;
int n=0;
	char ip[50];
  /*---- Create the socket. The three arguments are: ----*/
  /* 1) Internet domain 2) Stream socket 3) Default protocol (TCP in this case) */
  clientSocket = socket(PF_INET, SOCK_STREAM, 0);

  /*---- Configure settings of the server address struct ----*/
  /* Address family = Internet */
  serverAddr.sin_family = AF_INET;
  /* Set port number, using htons function to use proper byte order */
  serverAddr.sin_port = htons(5432);
  /* Set IP address to localhost */
	  serverAddr.sin_addr.s_addr = inet_addr("127.0.0.1");

  /* Set all bits of the padding field to 0 */
  memset(serverAddr.sin_zero, '\0', sizeof serverAddr.sin_zero);

  /*---- Connect the socket to the server using the address struct ----*/
  addr_size = sizeof serverAddr;
  connect(clientSocket, (struct sockaddr *) &serverAddr, addr_size);
printf("fine");
/*FILE* fp;
fp = fopen("my.jpeg", "a+b");
if (fp == NULL)
{
    printf("File not found!\n");
    return NULL;
}

/* Time to Receive the File */
/*while (1)
{
    bzero(buffer,1024);
    n = read(thisfd,buffer,1023);
    if (n < 0) error("ERROR reading from socket");

    n = fwrite(buffer, sizeof(char), sizeof(buffer), fp);
    if (n < 0) error("ERROR writing in file");

    n = write(thisfd,"I am getting your file...",25);
    if (n < 0) error("ERROR writing to socket");
} /* end child while loop */

//fclose(fp);
	
	printf("\ngive your input\n");
	scanf("%[^\n]",buffer);
//strcpy(buffer,"2 cats 3 cars 1 dogs and 2 trucks");
  send(clientSocket,buffer,strlen(buffer)+1,0);
int dogs=1;
int cats=2;
int cars=3;
int trucks=2;
int bytesReceived = 0;
char recvBuff[1024];
FILE* fp;
fp = fopen("a1.zip", "ab"); 
    	if(NULL == fp)
    	{
       	 printf("Error opening file");
         return 1;
    	}
    long double sz=1;
    /* Receive data in chunks of 256 bytes */
    while((bytesReceived = read(clientSocket, recvBuff, 1024)) > 0)
    { 
        
       
        // recvBuff[n] = 0;
        fwrite(recvBuff, 1,bytesReceived,fp);
        // printf("%s \n", recvBuff);
    }
fclose(fp);
/*char s[100];


for(int i=1;i<=trucks;i++)
{
	sprintf(s,"images/truck_%d.jpeg",i);
	int fsize;
    // result = recv(clientSocket, &fsize, sizeof(int),0);
    recv(clientSocket,&fsize,sizeof(int),0);
    // if(result<0) printf("wrong\n" );
    int size = ntohl(fsize);
    printf("size = %d\n",size );
    //Read Picture Byte Array
    // printf("Reading Picture Byte Array\n");
    char buffer[size];
    recv(clientSocket, buffer, size,0);
    // printf("okay\n" );

    //Convert it Back into Picture
    // printf("Converting Byte Array to Picture\n");
    FILE *image;
    // printf("okay");
    image = fopen(s, "w");
    int i=0;
    while(i<=size) fputc(buffer[i++],image);
    // fwrite(p_array, 1, sizeof(p_array), image);
fclose(image);
}
for(int i=1;i<=dogs;i++)
{
	sprintf(s,"images/doggo_%d.jpeg",i);
	int fsize;
    // result = recv(clientSocket, &fsize, sizeof(int),0);
    recv(clientSocket,&fsize,sizeof(int),0);
    // if(result<0) printf("wrong\n" );
    int size = ntohl(fsize);
    printf("size = %d\n",size );
    //Read Picture Byte Array
    // printf("Reading Picture Byte Array\n");
    char buffer[size];
    recv(clientSocket, buffer, size,0);
    // printf("okay\n" );

    //Convert it Back into Picture
    // printf("Converting Byte Array to Picture\n");
    FILE *image;
    // printf("okay");
    image = fopen(s, "w");
    int i=0;
    while(i<=size) fputc(buffer[i++],image);
    // fwrite(p_array, 1, sizeof(p_array), image);
fclose(image);
}
for(int i=1;i<=cats;i++)
{
	sprintf(s,"images/catto_%d.jpeg",i);
	int fsize;
    // result = recv(clientSocket, &fsize, sizeof(int),0);
    recv(clientSocket,&fsize,sizeof(int),0);
    // if(result<0) printf("wrong\n" );
    int size = ntohl(fsize);
    printf("size = %d\n",size );
    //Read Picture Byte Array
    // printf("Reading Picture Byte Array\n");
    char buffer[size];
    recv(clientSocket, buffer, size,0);
    // printf("okay\n" );

    //Convert it Back into Picture
    // printf("Converting Byte Array to Picture\n");
    FILE *image;
    // printf("okay");
    image = fopen(s, "w");
    int i=0;
    while(i<=size) fputc(buffer[i++],image);
    // fwrite(p_array, 1, sizeof(p_array), image);
fclose(image);
}

for(int i=1;i<=cars;i++)
{
	sprintf(s,"images/car_%d.jpeg",i);
	int fsize;
    // result = recv(clientSocket, &fsize, sizeof(int),0);
    recv(clientSocket,&fsize,sizeof(int),0);
    // if(result<0) printf("wrong\n" );
    int size = ntohl(fsize);
    printf("size = %d\n",size );
    //Read Picture Byte Array
    // printf("Reading Picture Byte Array\n");
    char buffer[size];
    recv(clientSocket, buffer, size,0);
    // printf("okay\n" );

    //Convert it Back into Picture
    // printf("Converting Byte Array to Picture\n");
    FILE *image;
    // printf("okay");
    image = fopen(s, "w");
    int i=0;
    while(i<=size) fputc(buffer[i++],image);
    // fwrite(p_array, 1, sizeof(p_array), image);
fclose(image);
}


/*
printf("Reading Picture Size\n");
long long int size;
int stat;
do{
stat = read(clientSocket, &size, sizeof(long long int));
}while(stat < 0);
printf("%lld\n",size);
int byte_read;
char p_array[size];
do{
byte_read=read(clientSocket, p_array, size);
printf("%d",byte_read);
}while(byte_read<0);
FILE *image;
image = fopen("my.jpeg", "wb");
fwrite(p_array, 1, sizeof(p_array), image);
fclose(image);

    /*strcpy(buffer,"2 cats 3 cars 1 dogs and 4 trucks");
  send(clientSocket,buffer,strlen(buffer)+1,0);

  FILE* fp;
  fp=fopen("a1.jpg","w");
  int file_size;
  read(clientSocket,&file_size,sizeof(file_size));
  char recvd_file[file_size];
  read(clientSocket,recvd_file,file_size);

  fwrite(recvd_file,1,sizeof(recvd_file),fp);
  fclose(fp);

  /*---- Read the message from the server into the buffer ----*/
 /* recv(clientSocket, buffer, 1024, 0);


printf("fine");
  printf("Data received: %s",buffer);
FILE* fp;
	fp=fopen("cli.html","w");
printf("fine");

		while( (n = recv(clientSocket, buffer, 1024, 0)) > 0 )
{
	fputs(buffer,fp);
printf("recev %s",buffer);

}
fclose(fp) ;
*/
 char c[1000]={0};
	sprintf(c, "./y.sh");
			system(c);
  return 0;
}
