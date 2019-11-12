package com.example.sendnotification;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.os.Message;
import android.os.StrictMode;
import android.util.Log;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.HttpResponse;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.google.firebase.iid.FirebaseInstanceId;
import com.google.firebase.messaging.FirebaseMessaging;

import java.util.HashMap;
import java.util.List;
import java.util.Map;

public class LoginActivity extends AppCompatActivity implements IRequestListener{

    EditText et_username,et_password;
    Button bt_login,bt_cancel;
    public static final String BACKEND_URL_BASE = "http://enquiry.airbil.in";
    IRequestListener listener;
    String token="";
    private TokenService tokenService;
    private static final String TAG = "LoginActivity";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        requestWindowFeature(Window.FEATURE_NO_TITLE);
        getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN,
                WindowManager.LayoutParams.FLAG_FULLSCREEN);
        setContentView(R.layout.activity_login);

        //javac
        StrictMode.setThreadPolicy(new StrictMode.ThreadPolicy.Builder().permitNetwork().build());

        FirebaseMessaging.getInstance().subscribeToTopic("test");
        final String token1 = FirebaseInstanceId.getInstance().getToken();
        Log.d(TAG, "Token: " + token1);

        //Call the token service to save the token in the database
        tokenService = new TokenService(this, this);
        tokenService.registerTokenInDB(token1);

        final SharedPreferences pref = getApplicationContext().getSharedPreferences("MyPref", 0); // 0 - for private mode
        final SharedPreferences.Editor editor = pref.edit();

        et_username=(EditText)findViewById(R.id.et_username);
        et_password=(EditText)findViewById(R.id.et_password);

        bt_login=(Button)findViewById(R.id.bt_login);
        bt_cancel=(Button)findViewById(R.id.bt_cancel);

        bt_cancel.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent homeIntent = new Intent(Intent.ACTION_MAIN);
                homeIntent.addCategory( Intent.CATEGORY_HOME );
                homeIntent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                startActivity(homeIntent);
            }
        });

        bt_login.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                if(et_username.getText().toString().equals("") && et_password.getText().toString().equals("")){
                    et_username.setError("Enter Username");
                    et_password.setError("Enter Password");
                }else if(et_username.getText().toString().equals("")){
                    et_username.setError("Enter Username");
                }else if(et_password.getText().toString().equals("")){
                    et_password.setError("Enter Password");
                }else {
                    // Instantiate the RequestQueue.
                    RequestQueue queue = Volley.newRequestQueue(getApplicationContext());
                    String url = BACKEND_URL_BASE + "/PHP/fcmtest/login_check.php";

                    // Request a string response from the provided URL.
                    StringRequest stringRequest = new StringRequest(Request.Method.POST, url,
                            new Response.Listener<String>() {
                                @Override
                                public void onResponse(String response) {

                                    if(response.equals("Success")) {
                                        Toast.makeText(getApplicationContext(), "Login Successfully", Toast.LENGTH_LONG).show();
                                        editor.putString("Username",et_username.getText().toString());
                                        editor.putString("Password",et_password.getText().toString());
                                        editor.commit();
                                        token=pref.getString("Token","");
                                        if(pref.getString("token_flag","").equals("1")) {
                                            //callUrlApi(et_username.getText().toString(), et_password.getText().toString(), getApplicationContext(), token);
                                            //Toast.makeText(getApplicationContext(),"Call web Api",Toast.LENGTH_SHORT).show();
                                            Intent i=new Intent(getApplicationContext(),CallUrlActivity.class);
                                            i.putExtra("mobile_no",et_username.getText().toString());
                                            i.putExtra("password",et_password.getText().toString());
                                            startActivity(i);
                                        }else{
                                            //Toast.makeText(getApplicationContext(),"Call Updated",Toast.LENGTH_SHORT).show();
                                            UpdateToken(et_username.getText().toString(), et_password.getText().toString(), getApplicationContext(), token);
                                            Intent i=new Intent(getApplicationContext(),CallUrlActivity.class);
                                            i.putExtra("mobile_no",et_username.getText().toString());
                                            i.putExtra("password",et_password.getText().toString());
                                            startActivity(i);
                                        }
                                    }else if(response.equals("Fail")){
                                        Toast.makeText(getApplicationContext(), "Incorrect Username and Password", Toast.LENGTH_LONG).show();
                                    }else {
                                        Toast.makeText(getApplicationContext(), "Something Went to Wrong! Please check your Internet Connection", Toast.LENGTH_LONG).show();
                                    }
                                }
                            }, new Response.ErrorListener() {
                                @Override
                                public void onErrorResponse(VolleyError error) {
                                    Toast.makeText(getApplicationContext(),"Something Went To Wrong!"+error,Toast.LENGTH_LONG).show();
                                }
                            }) {
                                @Override
                                protected Map<String, String> getParams() {
                                    Map<String, String> params = new HashMap<String, String>();
                                    params.put("mobile_no", et_username.getText().toString());
                                    params.put("password", et_password.getText().toString());
                                    return params;
                                }
                            };
                            // Add the request to the RequestQueue.
                            queue.add(stringRequest);
                    }
                }
            });
        }

        private static final int TIME_DELAY = 2000;
        private static long back_pressed;
        @Override
        public void onBackPressed() {
            if (back_pressed + TIME_DELAY > System.currentTimeMillis()) {
                //super.onBackPressed();
                Intent homeIntent = new Intent(Intent.ACTION_MAIN);
                homeIntent.addCategory( Intent.CATEGORY_HOME );
                homeIntent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                startActivity(homeIntent);
            }else{
                Toast.makeText(getBaseContext(), "Press once again to exit!",
                Toast.LENGTH_SHORT).show();
            }
            back_pressed = System.currentTimeMillis();
        }

    public static void callUrlApi(final String Username, final String Password, final Context context, final String token){
            try {
                RequestQueue queue = Volley.newRequestQueue(context);
                String url = BACKEND_URL_BASE + "/PHP/fcmtest/callurl.php";

                // Request a string response from the provided URL.
                StringRequest stringRequest = new StringRequest(Request.Method.POST, url,
                        new Response.Listener<String>() {
                            @Override
                            public void onResponse(String response) {
                                Toast.makeText(context, "Response=" + response, Toast.LENGTH_LONG).show();
                            }
                        }, new Response.ErrorListener() {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Toast.makeText(context, "Something Went To Wrong!", Toast.LENGTH_LONG).show();
                    }
                }) {
                    @Override
                    protected Map<String, String> getParams() {
                        Map<String, String> params = new HashMap<String, String>();
                        params.put("mobile_no", Username);
                        params.put("password", Password);
                        params.put("token", token);
                        return params;
                    }

                };
                // Add the request to the RequestQueue.
                queue.add(stringRequest);
            }catch (Exception e){
                e.printStackTrace();
                Toast.makeText(context,"Error="+e,Toast.LENGTH_LONG).show();
            }
    }

    public static void UpdateToken(final String Username, final String Password, final Context context, final String token){
        final SharedPreferences pref = context.getSharedPreferences("MyPref", 0); // 0 - for private mode
        final SharedPreferences.Editor editor = pref.edit();
        try {
            RequestQueue queue = Volley.newRequestQueue(context);
            String url = BACKEND_URL_BASE + "/PHP/fcmtest/callurl.php";

            // Request a string response from the provided URL.
            StringRequest stringRequest = new StringRequest(Request.Method.POST, url,
                    new Response.Listener<String>() {
                        @Override
                        public void onResponse(String response) {
                            if(response.equals("Record updated successfully")){
                                editor.putString("token_flag","1");
                                editor.commit();
                            }
                        }
                    }, new Response.ErrorListener() {
                @Override
                public void onErrorResponse(VolleyError error) {
                    Toast.makeText(context, "Something Went To Wrong!", Toast.LENGTH_LONG).show();
                }
            }) {
                @Override
                protected Map<String, String> getParams() {
                    Map<String, String> params = new HashMap<String, String>();
                    params.put("mobile_no", Username);
                    params.put("password", Password);
                    params.put("token", token);
                    return params;
                }

            };
            // Add the request to the RequestQueue.
            queue.add(stringRequest);
        }catch (Exception e){
            e.printStackTrace();
            Toast.makeText(context,"Error="+e,Toast.LENGTH_LONG).show();
        }
    }

    @Override
    public void onComplete() {

    }

    @Override
    public void onError(String message) {

    }
}
