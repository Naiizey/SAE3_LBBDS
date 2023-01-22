CC=gcc
CFLAGS=-Wall
CFLAGS_SSL= -lcrypto -lssl
DEST=./
ROOT=./
BIN=$(ROOT)bin/
FILE=$(ROOT)file/
SRC= $(ROOT)src/
EXT= $(ROOT)ext/
HEADER= $(ROOT)header/
TEST= $(ROOT)test/

all: simulateur

simulateur : $(SRC)lbbdp.c $(BIN)json_interpret.o $(BIN)fifo.o $(BIN)cJSON.o $(BIN)user.o $(BIN)cJSON.o
	$(CC) -I $(HEADER) -o $(DEST)$@ $^ $(CFLAGS) $(CFLAGS_SSL)


json:  $(BIN)json_interpret.o $(BIN)fifo.o $(BIN)cJSON.o 
	$(CC) -o $@ $^ $(CFLAGS) 
	

$(BIN)cJSON.o : $(EXT)cJSON.c
	$(CC) -I $(HEADER) -o $@ -c $< $(CFLAGS)

$(BIN)user.o :  $(SRC)user.c
	$(CC) -o $@ -c $< -I $(HEADER) $(CFLAGS) $(CFLAGS_SSL)

$(BIN)%.o : $(SRC)%.c
	$(CC) -I $(HEADER) -o $@ -c $< $(CFLAGS)

