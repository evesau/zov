#include <my_global.h>
#include <mysql.h>

void finish_with_error(MYSQL *con)
{
  fprintf(stderr, "%s\n", mysql_error(con));
  mysql_close(con);
  exit(1);        
}

int insert_dlr(MYSQL *con, char *sql);
char *data(MYSQL *con, char *sql);

int main(int argc, char **argv)
{
	printf("MySQL client version: %s\n", mysql_get_client_info());

	MYSQL *con = mysql_init(NULL);

	if (con == NULL)
	{
		fprintf(stderr, "%s\n", mysql_error(con));
		exit(1);
	}

	if (mysql_real_connect(con, "10.186.188.188", "smsmkt", "231mktsms", "sms_esau", 0, NULL, 0) == NULL) 
	{
		finish_with_error(con);
	}

	int id;
        char insert[300];

	char *datos = data(con, "SELECT * FROM sms WHERE entry_time >= '2018-09-12 09:00:00' AND source LIKE '24766' AND status = 'delivered' AND status_dlr NOT IN ('ACCEPTD') ORDER BY entry_time ASC LIMIT 5");

	printf("%s\n",datos);
	printf("\n");
        /*char *carrier;
        char *source;
        char *msisdn;
        char *content;
        char *dlr;
        char *estatus;
        char *message_id;
        
        insert[0]=0;
        carrier = "'telcel',";
        printf("%s\n",carrier);
        source = "'59850',";
        msisdn = "525521984192,";
        content = "'Zahira Marisol Torre',";
        dlr = "'id:0b6469b0-6d88-11e8-a95e-000c29bbdf85 sub:001 dlvrd:001 submit date:1806111459 done date:1806111459 stat:ACCEPTD err:000 text:Zahira Marisol Torre',";
        estatus = "'ACCEPTD',";*/


	/*strcpy(insert,"INSERT INTO sms_dlr(entry_time, carrier, source, destination, content, dlr, status, message_id) VALUES (NOW(),");
	strcat(insert, carrier);
	strcat(insert, source);
	strcat(insert, msisdn);
	strcat(insert, content);
	strcat(insert, dlr);
	strcat(insert, estatus);
	strcat(insert, message_id);
	strcat(insert , ")");

	printf("%s\n",insert);*/

	//insert = "INSERT INTO sms_dlr(entry_time, carrier, source, destination, content, dlr, status, message_id) VALUES (NOW(),'telcel','59850',525521984192,'Zahira Marisol Torre','id:0b6469b0-6d88-11e8-a95e-000c29bbdf85 sub:001 dlvrd:001 submit date:1806111459 done date:1806111459 stat:ACCEPTD err:000 text:Zahira Marisol Torre','ACCEPTD','0b6469b0-6d88-11e8-a95e-000c29bbdf85');";

	/*id = insert_dlr(con,insert);

	if(id){
		printf("%d\n",id);
	}*/
  
	mysql_close(con);

	exit(0);

}

int insert_dlr(MYSQL *con, char *sql){
	int id;
	if(mysql_query(con, sql)){
	    finish_with_error(con);
	}
  	id = mysql_insert_id(con);
	
	return id;

}

char *data(MYSQL *con, char *sql){
	char *buf;// = malloc(25);
	if(buf == NULL)
		return NULL;
	else
		if(mysql_query(con, sql)){
			finish_with_error(con);
		}

		MYSQL_RES *result = mysql_store_result(con);
		if(result == NULL)
			finish_with_error(con);
		
		int num_fields = mysql_num_fields(result);
		MYSQL_ROW row;
		while ((row = mysql_fetch_row(result))){
			for(int i = 0; i < num_fields; i++){
				buf = row[i];
				printf("%s\n", row[i] ? row[i] : "NULL");
			}
		}
	return buf;
}

int total_array(char *dato){
	int total;
	total = sizeof(dato)/sizeof(dato[0]);
	return total;
}

// Fin
