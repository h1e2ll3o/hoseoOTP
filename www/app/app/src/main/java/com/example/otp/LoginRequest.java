package com.example.otp;

import com.android.volley.AuthFailureError;
import com.android.volley.Response;
import com.android.volley.toolbox.StringRequest;

import java.util.HashMap;
import java.util.Map;

public class LoginRequest extends StringRequest {

    final static private String URL = "http://210.125.73.146:9928/app/php/Login.php";
    private Map<String, String> map;

    public LoginRequest(String userID, String userPassword, String userUUID, String userUUIDCheckNB, Response.Listener<String> listener) {
        super(Method.POST, URL, listener, null);

        map = new HashMap<>();
        map.put("userID", userID);
        map.put("userPassword", userPassword);
        map.put("userUUID", userUUID);
        map.put("userUUIDCheckNB", userUUIDCheckNB);
    }

    @Override
    protected Map<String, String>getParams() throws AuthFailureError {
        return map;
    }
}