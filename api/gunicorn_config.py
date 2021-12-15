import multiprocessing as mp
import or_api_config as cfg

cfg.load_config()

wsgi_app = "or_api:app"
bind = f"{cfg.get_config('flask_host')}:{cfg.get_config('flask_port')}"
workers = mp.cpu_count() * 2

if cfg.get_config("ssl_enabled"):
	certfile = cfg.get_config("certfile")
	keyfile = cfg.get_config("keyfile")

#raw_env = ["FLASK_ENV=production"]
