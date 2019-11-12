package com.example.sendnotification;

import android.content.Context;
import android.content.SharedPreferences;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import java.util.HashMap;
import java.util.Map;

public class TokenService {

    private static final String TAG = "TokenService";
    public static final String BACKEND_SERVER_IP = "103.71.64.153:85";
    public static final String BACKEND_URL_BASE = "http://" + BACKEND_SERVER_IP;
    private Context context;
    private IRequestListener listener;

    public TokenService(Context context, IRequestListener listener) {
        this.context = context;
        this.listener = listener;
    }

    public void registerTokenInDB(final String token) {
        // The call should have a back off strategy
        final SharedPreferences pref = context.getSharedPreferences("MyPref", 0); // 0 - for private mode
        final SharedPreferences.Editor editor = pref.edit();
        editor.putString("Token",token);
        editor.commit();
    }
}
