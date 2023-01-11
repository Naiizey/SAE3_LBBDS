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


json:  $(BIN)json_interpret.o $(BIN)fifo.o $(BIN)cJSON.o 
	$(CC) -o $@ $^ $(CFLAGS)

test_json: t_json
	cp $(wildcard $(FILE)*.json) $(DEST)

t_json: $(TEST)testJson.c $(BIN)fifo.o $(BIN)cJSON.o $(BIN)json_interpret.o 
	$(CC) -I $(HEADER) -o $(DEST)$@ $^ $(CFLAGS)

build_json: json
	cp $(wildcard $(FILE)*.json) $(DEST)
	
test_fifo: $(TEST)testFifo.c $(BIN)fifo.o
	$(CC) -I $(HEADER) -o $(DEST)$@ $^ $(CFLAGS)

$(BIN)cJSON.o : $(EXT)cJSON.c
	$(CC) -o $@ -c $< $(CFLAGS)
$(BIN)%.o : $(SRC)%.c
	$(CC) -I $(HEADER) -o $@ -c $< $(CFLAGS)

