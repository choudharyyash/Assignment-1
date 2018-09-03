
#include <stdio.h>
#include <netinet/in.h>
#include <string.h>
#include <sys/socket.h>
#include <arpa/inet.h>
#include <stdlib.h>


int main(){

  int welcomeSocket, newSocket;
  char buffer[1024];
  struct sockaddr_in serverAddr;
  struct sockaddr_storage serverStorage;
  socklen_t addr_size;

  /*---- Create the socket. The three arguments are: ----*/
  /* 1) Internet domain 2) Stream socket 3) Default protocol (TCP in this case) */
  welcomeSocket = socket(PF_INET, SOCK_STREAM, 0);

  /*---- Configure settings of the server address struct ----*/
  /* Address family = Internet */
  serverAddr.sin_family = AF_INET;
  /* Set port number, using htons function to use proper byte order */
  serverAddr.sin_port = htons(5432);
  /* Set IP address to localhost */
  serverAddr.sin_addr.s_addr = inet_addr("0.0.0.0");
  /* Set all bits of the padding field to 0 */
  memset(serverAddr.sin_zero, '\0', sizeof serverAddr.sin_zero);

  /*---- Bind the address struct to the socket ----*/
  bind(welcomeSocket, (struct sockaddr *) &serverAddr, sizeof(serverAddr));

  /*---- Listen on the socket, with 5 max connection requests queued ----*/
  if(listen(welcomeSocket,5)==0)
    printf("I'm listening\n");
  else
    printf("Error\n");

while(1){
  /*---- Accept call creates a new socket for the incoming connection ----*/
  addr_size = sizeof serverStorage;
  newSocket = accept(welcomeSocket, (struct sockaddr *) &serverStorage, &addr_size);

recv(newSocket, buffer, 1024, 0);

	char *p = (char *)buffer;
char *ind1=strstr(buffer, "dog");
char *ind2=strstr(buffer, "cat");
char *ind3=strstr(buffer, "car");
char *ind4=strstr(buffer, "truck");
 
    char dogs=(ind1-p)>0?buffer[ind1-p-2]:'0';
	char cats=(ind2-p)>0?buffer[ind2-p-2]:'0';
	char cars=(ind3-p)>0?buffer[ind3-p-2]:'0';
	char trucks=(ind4-p)>0?buffer[ind4-p-2]:'0';
	printf("\n%c %c %c %c \n",dogs,cats,cars,trucks);
  char c[1000]={0};
	sprintf(c, "./x.sh %c %c %c %c",dogs,cats,cars,trucks);
        system(c);
	printf("%s",c);

     
        FILE *fp = fopen("final.zip","rb");
        if(fp==NULL)
        {
            printf("File open error");
            return 1;   
        }   

        while(1)
        {
            unsigned char buff[1024]={0};
            int nread = fread(buff,1,1024,fp);
            
            if(nread > 0)
            {
                write(newSocket, buff, nread);
            }
            if (nread < 1024)
            {
                break;
            }
        }
fclose(fp);
close(newSocket);


char d[10];
sprintf(d, "./c.sh");
        system(d);
}
  return 0;
}
