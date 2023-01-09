CC=gcc
CFLAGS=-Wall
DEST=~/exec/sae/
ROOT=./
BIN=$(ROOT)bin/
FILE=$(ROOT)file/
SRC= $(ROOT)src/
EXT= $(ROOT)ext/
HEADER= $(ROOT)header/

all: build_json

json: $(BIN)cJSON.o $(BIN)json_interpret.o
	$(CC) $(INC) -o $(DEST)$@ $^ $(CFLAGS)


build_json: json
	cp $(wildcard $(FILE)*.json) $(DEST)


$(BIN)cJSON.o : $(EXT)cJSON.c
	$(CC) -o $@ -c $< $(CFLAGS)
$(BIN)%.o : $(SRC)%.c
	$(CC) -I $(HEADER) -o $@ -c $< $(CFLAGS)

