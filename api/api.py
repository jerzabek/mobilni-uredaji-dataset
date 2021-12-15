from flask import Flask
from flask_cors import CORS
import or_utils as util
from http import HTTPStatus

import or_api as cfg

cfg.load_config()

debug_mode = cfg.get_config("debug_mode")
ssl_enabled = cfg.get_config("ssl_enabled")

app = Flask(__name__)
CORS(app)


def connect_to_db():
    pass


@app.route('/hello', methods=['GET'])
def hello():
    return util.build_response({"success": True, "response": {"message": "Hello world!!"}}), HTTPStatus.OK


# Catch all route - used to match routes that do not exist
@app.route('/', defaults={'path': ''})
@app.route('/<path:path>')
def catch_all(path):
    return util.build_response({"error": "This endpoint does not exist."}), HTTPStatus.BAD_REQUEST


if __name__ == "__main__":
    flask_config = {
        "host": cfg.get_config("flask_host"),
        "port": cfg.get_config("flask_port"),
        "debug": debug_mode,
    }

    if ssl_enabled:
        flask_config["ssl_context"] = (cfg.get_config(
            "certfile"), cfg.get_config("keyfile"))

    app.run(**flask_config)
