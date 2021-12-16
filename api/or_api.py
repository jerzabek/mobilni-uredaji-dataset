import sys

from flask import Flask
from flask_cors import CORS
from http import HTTPStatus

import or_api_config as cfg
import or_api_utils as util
from or_api_db import OR_API_DB

# Loading configuration, used to store constant variables and environment variables
cfg.load_config()

debug_mode = cfg.get_config("debug_mode")
ssl_enabled = cfg.get_config("ssl_enabled")

# Database configuration object
db_config = {
    'user':                 cfg.get_config("db_username"),
    'password':             cfg.get_config("db_password"),
    'host':                 cfg.get_config("db_server"),
    'database':             cfg.get_config("db_name"),
    'raise_on_warnings':    True
}

db = OR_API_DB(db_config)

# If we were unable to connect to the database we will exit the application
if(not db.connect()):
    sys.exit()

app = Flask(__name__)
CORS(app)

@app.route('/phone/all', methods=['GET'])
def hello():
    cursor = db.get_cursor()

    cursor.execute("SELECT * FROM phone;")
    data = cursor.fetchall()
    cursor.close()

    return util.build_response({"success": True, "response": data}), HTTPStatus.OK


# Catch all route - used to match routes that do not exist
@app.route('/', defaults={'path': ''})
@app.route('/<path:path>')
def catch_all(path):
    return util.build_response({"error": "This endpoint does not exist."}), HTTPStatus.BAD_REQUEST


if __name__ == "__main__":
    # Flask webhost configuration
    flask_config = {
        "host": cfg.get_config("flask_host"),
        "port": cfg.get_config("flask_port"),
        "debug": debug_mode,
    }

    # HTTPS
    if ssl_enabled:
        flask_config["ssl_context"] = (
            cfg.get_config("certfile"),
            cfg.get_config("keyfile")
        )

    app.run(**flask_config)
