## Assignment 1: Minions
>> *NOTE*: All commands to be executed from the project root folder only

To build the client, do
```
cd client
gcc client.c
cd ..
```

To build the server do 
```
docker pull cashchoudhary/server_side
docker run --net="host" -it cashchoudhary/server_side
```

To start the server do (inside the container)
```
gcc server.c
./a.out
```
And in another terminal
```
./client/a.out
```
On receiving a request, the server will parse the request, find what images are to be sent and send them to the client.
The client will receive images, save them to the 'client' folder, build the HTML file and open it in the preferred browser.

## Possible Problems that could be faced
1. Problems related to permissions
Change permissions of all files to 775
2. *Browser not opening up*
All the images will be downloaded but the browser will fail to open saying 
> Running Firefox as root in a regular user's session is not supported.

The HTML file will be built. The problem is just that it is not opening. This is due to not running as root.
