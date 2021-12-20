import mysql.connector
from mysql.connector import errorcode


class OR_API_DB:
    def __init__(self, config) -> None:
        self.config = config

    def connect(self) -> bool:
        try:
            db_conn = mysql.connector.connect(**self.config)
        except mysql.connector.Error as err:
            if err.errno == errorcode.ER_ACCESS_DENIED_ERROR:
                print("Could not connect to database: invalid username/password")
            elif err.errno == errorcode.ER_BAD_DB_ERROR:
                print("Database does not exist")
            else:
                print(err)
            return False
        else:
            self.db_conn = db_conn
            return True

    def get_cursor(self, dictionary=True):
        return self.db_conn.cursor(dictionary=dictionary)

    def commit(self):
        self.db_conn.commit()
