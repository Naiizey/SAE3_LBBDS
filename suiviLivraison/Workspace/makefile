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

all: build_json


json:  $(BIN)json_interpret.o $(BIN)fifo.o $(BIN)cJSON.o 
	$(CC) -o $@ $^ $(CFLAGS)
	
test_user: $(TEST)testMd5.c $(BIN)user.o
	$(CC) -I $(HEADER) -o $(DEST)$@ $^ $(CFLAGS) $(CFLAGS_SSL)
	cp $(wildcard $(FILE)*Sim) $(DEST)

test_json: $(TEST)testJson.c $(BIN)fifo.o $(BIN)cJSON.o $(BIN)json_interpret.o 
	$(CC) -I $(HEADER) -o $(DEST)$@ $^ $(CFLAGS)
	cp $(wildcard $(FILE)*.json) $(DEST)

build_json: json
	cp $(wildcard $(FILE)*.json) $(DEST)
	
test_fifo: $(TEST)testFifo.c $(BIN)fifo.o
	$(CC) -I $(HEADER) -o $(DEST)$@ $^ $(CFLAGS)

$(BIN)cJSON.o : $(EXT)cJSON.c
	$(CC) -o $@ -c $< $(CFLAGS)

$(BIN)user.o :  $(SRC)user.c
	$(CC) -o $@ -c $< -I $(HEADER) $(CFLAGS) $(CFLAGS_SSL)

$(BIN)%.o : $(SRC)%.c
	$(CC) -I $(HEADER) -o $@ -c $< $(CFLAGS)

