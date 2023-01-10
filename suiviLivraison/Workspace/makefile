CC=gcc
CFLAGS=-Wall
DEST=./
ROOT=./
BIN=$(ROOT)bin/
FILE=$(ROOT)file/
SRC= $(ROOT)src/
EXT= $(ROOT)ext/
HEADER= $(ROOT)header/
TEST= $(ROOT)test/

all: build_json


json: $(BIN)fifo.o $(BIN)cJSON.o $(BIN)json_interpret.o 
	$(CC) -o $@ $^ $(CFLAGS)


build_json: json
	cp $(wildcard $(FILE)*.json) $(DEST)
	
test_fifo: $(TEST)testFifo.c $(BIN)fifo.o
	$(CC) -I $(HEADER) -o $(DEST)$@ $^ $(CFLAGS)

$(BIN)cJSON.o : $(EXT)cJSON.c
	$(CC) -o $@ -c $< $(CFLAGS)
$(BIN)%.o : $(SRC)%.c
	$(CC) -I $(HEADER) -o $@ -c $< $(CFLAGS)

