import sys

from flask import Flask, request
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


@app.after_request
def apply_caching(response):
    # We set the default response Content-Type header to JSON
    response.headers["Content-Type"] = "application/json"
    return response

# -------------------------------- Phones --------------------------------


@app.route('/phone/all', methods=['GET'])
def get_all_phones():
    cursor = db.get_cursor()

    cursor.execute("SELECT * FROM phone;")
    data = cursor.fetchall()
    cursor.close()

    return util.build_response({"success": True, "response": data}), HTTPStatus.OK


@app.route('/phone/<int:phone_id>', methods=['GET'])
def get_phone(phone_id):
    cursor = db.get_cursor()

    cursor.execute("SELECT * FROM phone WHERE id = %s;", (phone_id,))
    data = cursor.fetchall()
    cursor.close()

    if data is None:
        return util.build_response({"error": "Invalid request"}), HTTPStatus.BAD_REQUEST

    if not data:
        return util.build_response({"success": True, "response": data}), HTTPStatus.NOT_FOUND

    return util.build_response({"success": True, "response": data}), HTTPStatus.OK

# -------------------------------- Companies --------------------------------


@app.route('/company/all', methods=['GET'])
def get_all_companies():
    cursor = db.get_cursor()

    cursor.execute("SELECT * FROM company;")
    data = cursor.fetchall()
    cursor.close()

    return util.build_response({"success": True, "response": data}), HTTPStatus.OK


@app.route('/company/<int:company_id>', methods=['GET'])
def get_company(company_id):
    cursor = db.get_cursor()

    cursor.execute("SELECT * FROM company WHERE id = %s;", (company_id,))
    data = cursor.fetchall()
    cursor.close()

    if data is None:
        return util.build_response({"error": "Invalid request"}), HTTPStatus.BAD_REQUEST

    if not data:
        return util.build_response({"success": True, "response": data}), HTTPStatus.NOT_FOUND

    return util.build_response({"success": True, "response": data}), HTTPStatus.OK


@app.route('/company', methods=['POST'])
def create_comapny():
    if request.headers['Content-Type'] != "application/json":
        return util.build_response({"error": "Request must have Content-Type header set to 'application/json'"}), HTTPStatus.UNSUPPORTED_MEDIA_TYPE

    # Validation
    if "name" not in request.json:
        return util.build_response({"error": "Missing field 'name'"}), HTTPStatus.BAD_REQUEST

    if not request.json['name'] or not request.json['name'].strip():
        return util.build_response({"error": "Field 'name' must not be empty"}), HTTPStatus.BAD_REQUEST

    cursor = db.get_cursor()

    company_name = request.json['name']

    cursor.execute("INSERT INTO company (name) VALUES (%s);", (company_name,))
    db.commit()

    # We return the last inserted ID in the response
    cursor.execute('SELECT LAST_INSERT_ID() as id;')
    created_id = cursor.fetchone()['id']

    return util.build_response({"success": True, "response": created_id}), HTTPStatus.OK


@app.route('/company/<int:company_id>', methods=['PUT'])
def update_company(company_id):
    if request.headers['Content-Type'] != "application/json":
        return util.build_response({"error": "Request must have Content-Type header set to 'application/json'"}), HTTPStatus.UNSUPPORTED_MEDIA_TYPE

    mandatory_fields = ("name",)

    # Validation
    if not all(field in request.json.keys() for field in mandatory_fields):
        return util.build_response({"error": "Missing mandatory fields"}), HTTPStatus.BAD_REQUEST

    if not request.json['name'] or not request.json['name'].strip():
        return util.build_response({"error": "Field 'name' must not be empty"}), HTTPStatus.BAD_REQUEST

    cursor = db.get_cursor()

    company_name = request.json['name']

    cursor.execute("UPDATE company SET name=%s WHERE id=%s",
                   (company_name, company_id))
    db.commit()

    return util.build_response({"success": True}), HTTPStatus.OK

# -------------------------------- Processors --------------------------------


@app.route('/processor/all', methods=['GET'])
def get_all_processors():
    cursor = db.get_cursor()

    cursor.execute("SELECT * FROM processor;")
    data = cursor.fetchall()
    cursor.close()

    return util.build_response({"success": True, "response": data}), HTTPStatus.OK


@app.route('/processor/<int:processor_id>', methods=['GET'])
def get_processor(processor_id):
    cursor = db.get_cursor()

    cursor.execute("SELECT * FROM processor WHERE id = %s;", (processor_id,))
    data = cursor.fetchall()
    cursor.close()

    if data is None:
        return util.build_response({"error": "Invalid request"}), HTTPStatus.BAD_REQUEST

    if not data:
        return util.build_response({"success": True, "response": data}), HTTPStatus.NOT_FOUND

    return util.build_response({"success": True, "response": data}), HTTPStatus.OK

# -------------------------------- Cameras --------------------------------


@app.route('/camera/all', methods=['GET'])
def get_all_cameras():
    cursor = db.get_cursor()

    cursor.execute("SELECT * FROM camera;")
    data = cursor.fetchall()
    cursor.close()

    return util.build_response({"success": True, "response": data}), HTTPStatus.OK


@app.route('/camera/<int:camera_id>', methods=['GET'])
def get_camera(camera_id):
    cursor = db.get_cursor()

    cursor.execute("SELECT * FROM camera WHERE id = %s;", (camera_id,))
    data = cursor.fetchall()
    cursor.close()

    if data is None:
        return util.build_response({"error": "Invalid request"}), HTTPStatus.BAD_REQUEST

    if not data:
        return util.build_response({"success": True, "response": data}), HTTPStatus.NOT_FOUND

    return util.build_response({"success": True, "response": data}), HTTPStatus.OK


@app.route('/', defaults={'path': ''})
@app.route('/<path:path>')
def catch_all(path):
    # Catch all route - used to match routes that do not exist
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
