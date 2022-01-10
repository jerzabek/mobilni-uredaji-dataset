def build_response(parameters):
    response = {}

    if("success" in parameters and parameters["success"] == True):
        response['success'] = True
    else:
        response['success'] = False

    if("response" in parameters):
        response["response"] = parameters["response"]

    if("error" in parameters):
        response['error'] = parameters["error"]

    if("context" in parameters):
        response['@context'] = parameters["context"]

    return response
