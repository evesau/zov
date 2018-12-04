/* ------------------------------------------------------------ *
 * file:        sslconnect.c                                    *
 * purpose:     Example code for building a SSL connection and  *
 *              retrieving the server certificate               *
 * author:      06/12/2012 Frank4DD                             *
 *                                                              *
 * gcc -lssl -lcrypto -o sslconnect sslconnect.c                *
 * ------------------------------------------------------------ */

#include <sys/socket.h>
#include <resolv.h>
#include <netdb.h>
#include <netinet/in.h>
#include <arpa/inet.h>
#include <string.h>

#include <openssl/bio.h>
#include <openssl/ssl.h>
#include <openssl/err.h>
#include <openssl/pem.h>
#include <openssl/x509.h>
#include <openssl/x509_vfy.h>

/* ---------------------------------------------------------- *
 * First we need to make a standard TCP socket connection.    *
 * create_socket() creates a socket & TCP-connects to server. *
 * ---------------------------------------------------------- */
int create_socket(char[], BIO *);
/*james---------------------*/
 void ShutdownSSL( SSL *ssl);

/*--------------------------*/

int main(int argc,char *argv[]) {

  char           dest_url[] = "https://sns.ift.org.mx";
  BIO              *certbio = NULL;
  BIO               *outbio = NULL;
  X509                *cert = NULL;
  X509_NAME       *certname = NULL;
  const SSL_METHOD *method;
  SSL_CTX *ctx;
  SSL *ssl;
  int server = 0;
  int ret, i;
/*james----------------------*/
  char *charBuffer;
  int nBytesToRead=4096;
  int status;
/*---------------------------*/

  /* ---------------------------------------------------------- *
   * These function calls initialize openssl for correct work.  *
   * ---------------------------------------------------------- */
  OpenSSL_add_all_algorithms();
  ERR_load_BIO_strings();
  ERR_load_crypto_strings();
  SSL_load_error_strings();

  /* ---------------------------------------------------------- *
   * Create the Input/Output BIO's.                             *
   * ---------------------------------------------------------- */
  certbio = BIO_new(BIO_s_file());
  outbio  = BIO_new_fp(stdout, BIO_NOCLOSE);

  /* ---------------------------------------------------------- *
   * initialize SSL library and register algorithms             *
   * ---------------------------------------------------------- */
  if(SSL_library_init() < 0)
    BIO_printf(outbio, "Could not initialize the OpenSSL library !\n");

  /* ---------------------------------------------------------- *
   * Set SSLv2 client hello, also announce SSLv3 and TLSv1      *
   * ---------------------------------------------------------- */
  method = SSLv23_client_method();

  /* ---------------------------------------------------------- *
   * Try to create a new SSL context                            *
   * ---------------------------------------------------------- */
  if ( (ctx = SSL_CTX_new(method)) == NULL)
    BIO_printf(outbio, "Unable to create a new SSL context structure.\n");

  /* ---------------------------------------------------------- *
   * Disabling SSLv2 will leave v3 and TSLv1 for negotiation    *
   * ---------------------------------------------------------- */
  SSL_CTX_set_options(ctx, SSL_OP_NO_SSLv2);

  /* ---------------------------------------------------------- *
   * Create new SSL connection state object                     *
   * ---------------------------------------------------------- */
  ssl = SSL_new(ctx);

  /* ---------------------------------------------------------- *
   * Make the underlying TCP socket connection                  *
   * ---------------------------------------------------------- */
  server = create_socket(dest_url, outbio);
  if(server != 0)
  {
    //BIO_printf(outbio, "Successfully made the TCP connection to: %s.\n", dest_url);
  }

  /* ---------------------------------------------------------- *
   * Attach the SSL session to the socket descriptor            *
   * ---------------------------------------------------------- */
  SSL_set_fd(ssl, server);

  /* ---------------------------------------------------------- *
   * Try to SSL-connect here, returns 1 for success             *
   * ---------------------------------------------------------- */
  if ( SSL_connect(ssl) != 1 )
    BIO_printf(outbio, "Error: Could not build a SSL session to: %s.\n", dest_url);
  else
  {
    //BIO_printf(outbio, "Successfully enabled SSL/TLS session to: %s.\n", dest_url);
  }

  /* ---------------------------------------------------------- *
   * Get the remote certificate into the X509 structure         *
   * ---------------------------------------------------------- */
  cert = SSL_get_peer_certificate(ssl);
  if (cert == NULL)
    BIO_printf(outbio, "Error: Could not get a certificate from: %s.\n", dest_url);
  else
  {
    //BIO_printf(outbio, "Retrieved the server's certificate from: %s.\n", dest_url);
  }

  /* ---------------------------------------------------------- *
   * extract various certificate information                    *
   * -----------------------------------------------------------*/
  certname = X509_NAME_new();
  certname = X509_get_subject_name(cert);

  /* ---------------------------------------------------------- *
   * display the cert subject here                              *
   * -----------------------------------------------------------*/
  //BIO_printf(outbio, "Displaying the certificate subject data:\n");
  X509_NAME_print_ex(outbio, certname, 0, 0);
  //BIO_printf(outbio, "\n");


/*james-------------------------------*/
//Peticion 0!!!!

char peticion0[]="GET /sns-frontend/consulta-numeracion/numeracion-geografica.xhtml HTTP/1.1\r\nHost: sns.ift.org.mx:8081\r\nConnection: keep-alive\r\nCache-Control: max-age=0\r\nUpgrade-Insecure-Requests: 1\r\nUser-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36 OPR/39.0.2256.71\r\nAccept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8\r\nAccept-Encoding: gzip, deflate, lzma, sdch, br\r\nAccept-Language: es-ES,es;q=0.8\r\nCookie: _ga=GA1.3.1940549277.1475085636\r\n\r\n";

//printf("Peticion0[\n%s\n]",peticion0);

SSL_write(ssl,peticion0,strlen(peticion0));

FILE *fp;
char readdata0[100000];
char readdata1[100000];
char readdata2[100000];
char readdata3[100000];
//char msisdn[]="5529714691";
char msisdn[32]="";
strcpy(msisdn,argv[1]);
int ii=0;
fp=fopen("/home/smsmkt/public/apift/httpsift0.txt","w");
    while (1) {
        ii++;
        status = SSL_read( ssl, readdata0,99999);
        if ( status == 0 ) {break;}
        if ( status <  0 ) { sleep(1);/*printf("Esperando!!"); */continue; }
        fwrite( readdata0, 1, status, fp );
        if(readdata0[0]=='0'){ /*printf("Cero!!");*/break;}
    }
fclose(fp);
system("php /home/smsmkt/public/apift/FRONTAPPID.php >/home/smsmkt/public/apift/FRONTAPPID.txt");
system("php /home/smsmkt/public/apift/VIEWSTATE0.php >/home/smsmkt/public/apift/VIEWSTATE.txt");

printf("Terminando peticion0!!\n");

int c;
int limite=0;
char frontappid[128];
char viewstate[128];
char len[8];
fp=fopen("/home/smsmkt/public/apift/FRONTAPPID.txt","r");
do
   {
      c = fgetc(fp);
      if( feof(fp) )
      {
         break ;
      }
      frontappid[limite++]=c;
      frontappid[limite]='\0';
   }while(1);

   fclose(fp);

/////////////////////////////////////////////////////////////Peticion 2!!!!
char peticion2[2048];
char peticion2a[2048];

limite=0;
fp=fopen("/home/smsmkt/public/apift/VIEWSTATE.txt","r");
do
   {
      c = fgetc(fp);
      if( feof(fp) )
      {
         break ;
      }
      viewstate[limite++]=c;
      viewstate[limite]='\0';
   }while(1);

   fclose(fp);

sprintf(peticion2a,"javax.faces.partial.ajax=true&javax.faces.source=FORM_myform%%3ATXT_NationalNumber&javax.faces.partial.execute=FORM_myform%%3ATXT_NationalNumber&javax.faces.partial.render=FORM_myform%%3ABTN_publicSearch+FORM_myform%%3ATXT_LocalNumber+FORM_myform%%3ATXT_Nir+FORM_myform%%3ATXT_Population&javax.faces.behavior.event=keyup&javax.faces.partial.event=keyup&FORM_myform=FORM_myform&FORM_myform%%3ATXT_Population_input=&FORM_myform%%3ATXT_NationalNumber=%s&FORM_myform%%3ATXT_LocalNumber=&FORM_myform%%3ATXT_Nir=&javax.faces.ViewState=%s",msisdn,viewstate);

sprintf(peticion2,"POST /sns-frontend/consulta-numeracion/numeracion-geografica.xhtml HTTP/1.1\r\nHost: sns.ift.org.mx:8081\r\nConnection: keep-alive\r\nOrigin: https://sns.ift.org.mx:8081\r\nFaces-Request: partial/ajax\r\nContent-Type: application/x-www-form-urlencoded; charset=UTF-8\r\nAccept: application/xml, text/xml, */*; q=0.01\r\nX-Requested-With: XMLHttpRequest\r\nUser-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36 OPR/39.0.2256.71\r\nReferer: https://sns.ift.org.mx:8081/sns-frontend/consulta-numeracion/numeracion-geografica.xhtml\r\nAccept-Encoding: gzip, deflate, lzma, br\r\nAccept-Language: es-ES,es;q=0.8\r\nCookie: _ga=GA1.3.1940549277.1475085636; FRONTAPPID=%s\r\nContent-Length: %d\r\n\r\n",frontappid,(int)strlen(peticion2a));

printf("\nPeticion2[\n%s\n]\n\n",peticion2);
printf("\nPeticion2a[\n%s\n]\n",peticion2a);

SSL_write(ssl,peticion2,strlen(peticion2));
SSL_write(ssl,peticion2a,strlen(peticion2a));
fp=fopen("/home/smsmkt/public/apift/httpsift.txt","w");
    while (1) {
	status = SSL_read( ssl, readdata1,4098 );
	if ( status == 0 ) break;
	if ( status <  0 ) { sleep(1); continue; }
	fwrite( readdata1, 1, status, fp );
        //printf("\n%c\n%s",readdata1[0],readdata1);
        if(readdata1[0]=='<'){ /*printf("< --Cero!!");*/break;}
    }
fclose(fp);
//printf("\n\n\nRESPUESTA2 OK\n\n\n\n");
///////////////////////////////////////////////////////Peticion 3!!!!
char peticion3[2048];
char peticion3a[2048];

sprintf(peticion3a,"javax.faces.partial.ajax=true&javax.faces.source=FORM_myform%%3ATXT_NationalNumber&javax.faces.partial.execute=FORM_myform%%3ATXT_NationalNumber&javax.faces.partial.render=FORM_myform%%3ABTN_publicSearch+FORM_myform%%3ATXT_LocalNumber+FORM_myform%%3ATXT_Nir+FORM_myform%%3ATXT_Population&javax.faces.behavior.event=keyup&javax.faces.partial.event=keyup&FORM_myform=FORM_myform&FORM_myform%%3ATXT_NationalNumber=%s&javax.faces.ViewState=%s",msisdn,viewstate);

sprintf(peticion3,"POST /sns-frontend/consulta-numeracion/numeracion-geografica.xhtml HTTP/1.1\r\nHost: sns.ift.org.mx:8081\r\nConnection: keep-alive\r\nOrigin: https://sns.ift.org.mx:8081\r\nFaces-Request: partial/ajax\r\nContent-Type: application/x-www-form-urlencoded; charset=UTF-8\r\nAccept: application/xml, text/xml, */*; q=0.01\r\nX-Requested-With: XMLHttpRequest\r\nUser-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36 OPR/39.0.2256.71\r\nReferer: https://sns.ift.org.mx:8081/sns-frontend/consulta-numeracion/numeracion-geografica.xhtml\r\nAccept-Encoding: gzip, deflate, lzma, br\r\nAccept-Language: es-ES,es;q=0.8\r\nCookie: _ga=GA1.3.1940549277.1475085636; FRONTAPPID=%s\r\nContent-Length: %d\r\n\r\n",frontappid,(int)strlen(peticion3a));

//printf("\nPeticion3[\n%s\n]\n\n",peticion3);
//printf("\n\nPeticion3a[\n%s\n]\n",peticion3a);

SSL_write(ssl,peticion3,strlen(peticion3));

SSL_write(ssl,peticion3a,strlen(peticion3a));
//printf("\n\n\nRESPUESTA3 OK\n\n\n\n");
 fp=fopen("/home/smsmkt/public/apift/httpsift1.txt","w");
   while (1) {
        status = SSL_read( ssl, readdata2,100 );

        //ii = SSL_get_error (ssl, status);//auxiliar
        //printf("Error:%d\n",ii);

        if ( status == 0 ) break;
        if ( status <  0 ) { sleep(1); continue; }
        //printf("\n%c\n",readdata2[0]);
        fwrite( readdata2, 1, status, fp );
        if(readdata2[0]=='<'){ /*printf("<--Cero!!");*/break;}
    }
  fclose(fp);
////////////////////////////////////////////////////////////////////////Peticion 4!!!!
char peticion4[2048];
char peticion4a[2048];

sprintf(peticion4a,"javax.faces.partial.ajax=true&javax.faces.source=FORM_myform%%3ABTN_publicSearch&javax.faces.partial.execute=%%40all&javax.faces.partial.render=FORM_myform%%3AP_containerConsulta+FORM_myform%%3AP_containerpoblaciones+FORM_myform%%3AP_containernumeracion+FORM_myform%%3AP_containerinfo+FORM_myform%%3AP_containerLocal+FORM_myform%%3AP_containerDesplegable&FORM_myform%%3ABTN_publicSearch=FORM_myform%%3ABTN_publicSearch&FORM_myform=FORM_myform&FORM_myform%%3ATXT_NationalNumber=%s&javax.faces.ViewState=%s",msisdn,viewstate);

sprintf(peticion4,"POST /sns-frontend/consulta-numeracion/numeracion-geografica.xhtml HTTP/1.1\r\nHost: sns.ift.org.mx:8081\r\nConnection: keep-alive\r\nOrigin: https://sns.ift.org.mx:8081\r\nFaces-Request: partial/ajax\r\nContent-Type: application/x-www-form-urlencoded; charset=UTF-8\r\nAccept: application/xml, text/xml, */*; q=0.01\r\nX-Requested-With: XMLHttpRequest\r\nUser-Agent: Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36 OPR/39.0.2256.71\r\nReferer: https://sns.ift.org.mx:8081/sns-frontend/consulta-numeracion/numeracion-geografica.xhtml\r\nAccept-Encoding: gzip, deflate, lzma, br\r\nAccept-Language: es-ES,es;q=0.8\r\nCookie: _ga=GA1.3.1940549277.1475085636; FRONTAPPID=%s\r\nContent-Length: %d\r\n\r\n",frontappid,(int)strlen(peticion4a));

//printf("\nPeticion4[\n%s\n]\n\n",peticion4);
//printf("\nPeticion4a[\n%s\n]\n",peticion4a);

SSL_write(ssl,peticion4,strlen(peticion4));

SSL_write(ssl,peticion4a,strlen(peticion4a));

//printf("\n\n\nRESPUESTA4\n\n\n\n");

 fp=fopen("/home/smsmkt/public/apift/httpsift2.txt","w");
   while (1) {
        status = SSL_read( ssl, readdata3,99999 );
        if ( status == 0 ) break;
        if ( status <  0 ) { sleep(1); continue; }
        fwrite( readdata3, 1, status, fp );
        if(readdata3[0]=='0'){ /*printf("Cero!!");*/break;}
    }
  fclose(fp);
//system("php parsea_carrier.php >carrier.txt");
system("php /home/smsmkt/public/apift/parsea_carrier.php");


/*-----------------------------------*/
  /* ---------------------------------------------------------- *
   * Free the structures we don't need anymore                  *
   * -----------------------------------------------------------*/
  SSL_free(ssl);
  close(server);
  X509_free(cert);
  SSL_CTX_free(ctx);
  //BIO_printf(outbio, "\n\n\nFinished SSL/TLS connection with server: %s.\n", dest_url);
  return(0);
}

/* ---------------------------------------------------------- *
 * create_socket() creates the socket & TCP-connect to server *
 * ---------------------------------------------------------- */
int create_socket(char url_str[], BIO *out) {
  int sockfd;
  char hostname[256] = "";
  char    portnum[6] = "8081";
  char      proto[6] = "";
  char      *tmp_ptr = NULL;
  int           port;
  struct hostent *host;
  struct sockaddr_in dest_addr;

  /* ---------------------------------------------------------- *
   * Remove the final / from url_str, if there is one           *
   * ---------------------------------------------------------- */
  if(url_str[strlen(url_str)] == '/')
    url_str[strlen(url_str)] = '\0';

  /* ---------------------------------------------------------- *
   * the first : ends the protocol string, i.e. http            *
   * ---------------------------------------------------------- */
  strncpy(proto, url_str, (strchr(url_str, ':')-url_str));

  /* ---------------------------------------------------------- *
   * the hostname starts after the "://" part                   *
   * ---------------------------------------------------------- */
  strncpy(hostname, strstr(url_str, "://")+3, sizeof(hostname));

  /* ---------------------------------------------------------- *
   * if the hostname contains a colon :, we got a port number   *
   * ---------------------------------------------------------- */
  if(strchr(hostname, ':')) {
    tmp_ptr = strchr(hostname, ':');
    /* the last : starts the port number, if avail, i.e. 8443 */
    strncpy(portnum, tmp_ptr+1,  sizeof(portnum));
    *tmp_ptr = '\0';
  }

  port = atoi(portnum);

  if ( (host = gethostbyname(hostname)) == NULL ) {
    BIO_printf(out, "Error: Cannot resolve hostname %s.\n",  hostname);
    abort();
  }

  /* ---------------------------------------------------------- *
   * create the basic TCP socket                                *
   * ---------------------------------------------------------- */
  sockfd = socket(AF_INET, SOCK_STREAM, 0);

  dest_addr.sin_family=AF_INET;
  dest_addr.sin_port=htons(port);
  dest_addr.sin_addr.s_addr = *(long*)(host->h_addr);

  /* ---------------------------------------------------------- *
   * Zeroing the rest of the struct                             *
   * ---------------------------------------------------------- */
  memset(&(dest_addr.sin_zero), '\0', 8);

  tmp_ptr = inet_ntoa(dest_addr.sin_addr);

  /* ---------------------------------------------------------- *
   * Try to make the host connect here                          *
   * ---------------------------------------------------------- */
  if ( connect(sockfd, (struct sockaddr *) &dest_addr,
                              sizeof(struct sockaddr)) == -1 ) {
    BIO_printf(out, "Error: Cannot connect to host %s [%s] on port %d.\n",
             hostname, tmp_ptr, port);
  }

  return sockfd;
}

/*james funciones----------------------------------------------*/

void ShutdownSSL( SSL *ssl)
{
    SSL_shutdown(ssl);
}




/*------------------------------------------------------------*/
