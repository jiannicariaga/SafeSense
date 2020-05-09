#include <WiFi.h>
#include <HTTPClient.h>

//For DataBase connections
#include <MySQL_Connection.h>
#include <MySQL_Cursor.h>

//PINS For UART 
#define RXD2 16
#define TXD2 17

//Feedback from Radar
char feedback[35];

//Device name - defaulted to New Device
String devName = "New Device";
//Device location - defaulted to Home
String devLoc = "Home";
//Max Range of radar
String rang = "";
//Sensitivity of radar
String sens = "";
//Status of radar
String statu = "";
//ID of Device
String deviceID = "";

//WiFi credentials
const char* ssid     = "";
const char* passwordWiFi = "";

int count = 0;

char query[128];

//SiteGround MySQL IP
IPAddress server_addr(35,209,89,210);

//MySQL User credentials
char user[] = "";         
char password[] = "";     

//Key for device which is unique
String devKey = "W8NNEP1QLC7495HBS8";

//MySQL queries
char INSERT_SQL[] = "INSERT INTO db7xtqpcwdhn7t.activity_log (deviceID, data) VALUES ('%s','%s')";
char queryID[] = "SELECT deviceID FROM  db7xtqpcwdhn7t.devices WHERE authenticationKey = 'W8NNEP1QLC7495HBS8'";
char queryDN[] = "SELECT deviceName FROM  db7xtqpcwdhn7t.devices WHERE authenticationKey = 'W8NNEP1QLC7495HBS8'";
char queryDL[]= "SELECT deviceLocation FROM  db7xtqpcwdhn7t.devices WHERE authenticationKey = 'W8NNEP1QLC7495HBS8'";
char queryMR[]= "SELECT maxRange FROM  db7xtqpcwdhn7t.devices WHERE authenticationKey = 'W8NNEP1QLC7495HBS8'";
char queryS[]= "SELECT sensitivity FROM  db7xtqpcwdhn7t.devices WHERE authenticationKey = 'W8NNEP1QLC7495HBS8'";
char querySA[]= "SELECT showActivity FROM  db7xtqpcwdhn7t.devices WHERE authenticationKey = 'W8NNEP1QLC7495HBS8'";
char START[] = "INSERT IGNORE INTO  db7xtqpcwdhn7t.devices (authenticationKey, deviceName, deviceLocation, maxRange, sensitivity, showActivity) VALUES ('W8NNEP1QLC7495HBS8','New Device','Home','4.5','m','on')";

//MySQL connection
WiFiClient client;
MySQL_Connection conn((Client *)&client);

void setup() {
  Serial.begin(115200);

  //Connect to WiFi
  WiFi.begin(ssid, passwordWiFi);
  Serial.println("Connecting");
  while(WiFi.status() != WL_CONNECTED) { 
    delay(500);
    Serial.print(".");
  }
  Serial.println("");
  Serial.print("Connected to WiFi network with IP Address: ");
  Serial.println(WiFi.localIP());

  delay(1000);
  
  //Connect to MySQL Database
  Serial.println("Connecting...");
  if (conn.connect(server_addr, 3306, user, password)) {
    delay(1000);
    Serial.println("Success");
  }
  else
    Serial.println("Connection failed.");

  delay(1000);

  //Execute START MySQL statement
  MySQL_Cursor *cur_mem = new MySQL_Cursor(&conn);
  cur_mem->execute(START);

  delay(1000);

  row_values *row = NULL;
  column_names *columns = NULL;

  //Execute Device Name MySQL query
  cur_mem->execute(queryDN);
  columns = cur_mem->get_columns();
  do{
    row = cur_mem->get_next_row();
    if(row != NULL)
    {
      devName = row->values[0];
      Serial.println("NAME= " + devName);
    }
  } while(row != NULL);
  delay(500);

  //Execute Device Location MySQL query
  cur_mem->execute(queryDL);
  columns = cur_mem->get_columns();
  do{
    row = cur_mem->get_next_row();
    if(row != NULL)
    {
      devLoc= row->values[0];
      Serial.println("LOC= " + devLoc);
    }
  } while(row != NULL);

  delay(500);
  cur_mem->execute(queryID);
  columns = cur_mem->get_columns();
  do{
    row = cur_mem->get_next_row();
    if(row != NULL)
    {
      deviceID = row->values[0];
      Serial.println("DEVID= " + deviceID);
    }
  } while(row != NULL);
  
  delete cur_mem;
  
  delay(1000);

  //Start UART connection to radar
  Serial2.begin(115200, SERIAL_8N1, RXD2, TXD2);
  delay(1000);
  setRadar(1);
  delay(1000);
  setStatus(1);  
  setMaxRange(4.5);

  count = 0;
}

/*
 * Get incoming data from radar
 */
void response(){

  if (Serial2.available()) {

    char feedback[35];
    
    String tmp = Serial2.readStringUntil('\r');
    Serial.println("TMP = " + tmp + "END-TMP" + "SIZE=" + (int)strlen(tmp.c_str()));
    int I = (int)strlen(tmp.c_str());
    if(tmp != NULL && strstr(tmp.c_str(),"OK") == NULL && I > 2)
    {
      //Serial.println(tmp);
      strcpy(feedback,tmp.c_str());
      //Serial.print("Feedback=");Serial.println(feedback);

      Serial.println("Resp - Connecting...");
      if (conn.connect(server_addr, 3306, user, password)) {
        delay(100);
      }
    
      delay(100);
      
      row_values *row = NULL;
      column_names *columns = NULL;
      Serial.println("Recording data.");
    
      //Send Feedback to MySQL Database if there is data from radar
      MySQL_Cursor *cur_mem = new MySQL_Cursor(&conn);
        const char* feed = strstr(feedback,"Presence");
        //Serial.print("FEED=");Serial.println(feed);
        if(feed != NULL)
        {
          sprintf(query,INSERT_SQL,deviceID,feed);
          Serial.print("query= ");Serial.println(query);
          cur_mem->execute(query);
        }
      delay(100);
      delete cur_mem;
    }
    delay(100);
  }
}


void loop() {

  response();

  if(count < 20)
  {
    count = count + 1;
    delay(10);
  }
  else
  {
    count = 0;
    Serial.println("Get from DB - Connecting...");
    if (conn.connect(server_addr, 3306, user, password)) {
      delay(100);
      Serial.println("Success");
    }
    else
      Serial.println("Connection failed.");
  
    delay(100);
    
    row_values *row = NULL;
    column_names *columns = NULL;
    Serial.println("Recording data.");
  
    //Send Feedback to MySQL Database if there is data from radar
    MySQL_Cursor *cur_mem = new MySQL_Cursor(&conn);
    delay(100);
  
    //Update the Device Name, location, and settings from Database
    
    cur_mem->execute(queryDN);
    columns = cur_mem->get_columns();
    do {
      row = cur_mem->get_next_row();
      if(row != NULL)
      {
        devName = row->values[0];
        Serial.println("NAME= " + devName);
      }
    } while(row != NULL);
    delay(100);
    cur_mem->execute(queryDL);
    columns = cur_mem->get_columns();
    do {
      row = cur_mem->get_next_row();
      if(row != NULL)
      {
        devLoc= row->values[0];
        Serial.println("LOC= " + devLoc);
      }
    } while(row != NULL);  
    delay(100);    
    cur_mem->execute(queryMR);
    columns = cur_mem->get_columns();
    do {
      row = cur_mem->get_next_row();
      if(row != NULL)
      {
        rang = row->values[0];
        char *eptr;
        double val = strtod(rang.c_str(),&eptr);
        bool tempi = setMaxRange(val);
        Serial.println("RANGE= " + rang);
      }
    } while(row != NULL);
    delay(100);
    cur_mem->execute(queryS);
    columns = cur_mem->get_columns();
    do{
      row = cur_mem->get_next_row();
      if(row != NULL)
      {
        sens = row->values[0];
        if(strstr(sens.c_str(),"m") != NULL)
        {
          setSensitivity('m');
        }
        else if(strstr(sens.c_str(),"h") != NULL)
        {
          setSensitivity('h');
        }
        else
        {
          setSensitivity('l');
        }
        Serial.println("SENS= " + sens);
      }
    } while(row != NULL);
    delay(100);
    cur_mem->execute(querySA);
    columns = cur_mem->get_columns();
    do
    {
      row = cur_mem->get_next_row();
      if(row != NULL)
      {
        statu = row->values[0];
        if(strstr(statu.c_str(),"off") != NULL)
        {
          setStatus(0);
        }
        else
        {
          setStatus(1);
        }
        Serial.println("Status= " + statu);
      }
    } while(row != NULL);
    
    //Free memory
    delete cur_mem;
  }
}

//The following functions are used to set functions on the radar via UART
bool setMaxRange(const double val){
  if (val > 10.2 or val < 0.66)
  {
     Serial.println("RANGE SET FAILED");
    return false;
  }
  String cm = "maxrange ";
  cm.concat(val);
  Serial2.println(cm+'\n');
  Serial2.flush();
  return true;
}

bool setSensitivity(const char sen){
  if (sen == 'h'){
    Serial2.println("sensitivity high\n");
    Serial2.flush();
    return true;
  }
  else if (sen == 'm'){
    Serial2.println("sensitivity medium\n");
    Serial2.flush();
    return true;
  }
  else if (sen == 'l'){
    Serial2.println("sensitivity low\n");
    Serial2.flush();
    return true;
  }
  Serial.println("SENSITIVITY SET FAILED");
  return false;
}

bool setStatus(const int val){
  if (val == 1){
    Serial2.println("status on\n");
    Serial2.flush();
    return true;
  }
  else if (val == 0){
    Serial2.println("status off\n");
    Serial2.flush();
    return true;
  }
  Serial.println("STATUS SET FAILED");
  return false;
}

bool setRadar(const int val){
  if (val == 1){
    Serial2.println("radar enable\n");
    Serial2.flush();
    return true;
  }
  else if (val == 0){
    Serial2.println("radar disable\n");
    Serial2.flush();
    return true;
  }
  return false;
}

void reset(void){
  Serial2.println("reset\n");
  Serial2.flush();
}

bool setDetect(const int val){
  if (val == 0){
    Serial2.println("detect macro_only\n");
    Serial2.flush();
    return true;
  }
  else if (val == 1){
    Serial2.println("detect micro_only\n");
    Serial2.flush();
    return true;
  }
  else if (val == 2){
    Serial2.println("detect macro_and_micro\n");
    Serial2.flush();
    return true;
  }
  else if (val == 3){
    Serial2.println("detect macro_then_micro\n");
    Serial2.flush();
    return true;
  }
  return false;
}

bool setMacroThreshold(const double val){
  if (val < 0)
    return false;
  String cm = "macrothreshold ";
  cm.concat(val);
  Serial2.println(cm+'\n');
  Serial2.flush();
  return true;
}

bool setMicroThreshold(const double val){
  if (val < 0)
    return false;
  String cm = "microthreshold ";
  cm.concat(val);
  Serial2.println(cm+'\n');
  Serial2.flush();
  return true;
}

bool setMacroValid(const double val){
  if (val > 30 or val < 0.5)
    return false;
  String cm = "macrovalid ";
  cm.concat(val);
  Serial2.println(cm+'\n');
  Serial2.flush();
  return true;
}

bool setMicroValid(const double val){
  if (val > 30 or val < 1.5)
    return false;
  String cm = "microvalid ";
  cm.concat(val);
  Serial2.println(cm+'\n');
  Serial2.flush();
  return true;
}

bool setScan(const int val){
  if (val == 1){
    Serial2.println("scan on\n");
    Serial2.flush();
    return true;
  }
  else if (val == 0){
    Serial2.println("scan off\n");
    Serial2.flush();
    return true;
  }
  return false;
}

bool setLed(const int val){
  if (val == 1){
    Serial2.println("ledindication on\n");
    Serial2.flush();
    return true;
  }
  else if (val == 0){
    Serial2.println("ledindication off\n");
    Serial2.flush();
    return true;
  }
  return false;
}

bool setGpioInvert(const int val){
  if (val == 1){
    Serial2.println("gpioinvert on\n");
    Serial2.flush();
    return true;
  }
  else if (val == 0){
    Serial2.println("gpioinvert off\n");
    Serial2.flush();
    return true;
  }
  return false;
}

bool setAdcrate(const int val){
  if (val > 2424 or val < 1000)
    return false;
  String cm = "adcrate ";
  cm.concat(val);
  Serial2.println(cm+'\n');
  Serial2.flush();
  return true;
}

bool setGaindb(const int val){
  if (val == 30 or val == 40 or val == 60){
    String cm = "gaindb ";
    cm.concat(val);
    Serial2.println(cm+'\n');
    Serial2.flush();
    return true;
  }
  return false;
}

bool setSpitest(const int val){
  if (val == 1){
    Serial2.println("spitest enable\n");
    Serial2.flush();
    return true;
  }
  else if (val == 0){
    Serial2.println("spitest disable\n");
    Serial2.flush();
    return true;
  }
  return false;
}

bool setRfcwtest(const char sen){
  if (sen == 'h'){
    Serial2.println("sensitivity hi\n");
    Serial2.flush();
    return true;
  }
  else if (sen == 'm'){
    Serial2.println("sensitivity mid\n");
    Serial2.flush();
    return true;
  }
  else if (sen == 'l'){
    Serial2.println("sensitivity low\n");
    Serial2.flush();
    return true;
  }
  else if (sen == 'd'){
    Serial2.println("sensitivity disable\n");
    Serial2.flush();
    return true;
  }
  return false;
}
