package com.example.sendnotification;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Context;
import android.content.Intent;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.Bundle;
import android.view.View;
import android.view.Window;
import android.view.WindowManager;
import android.webkit.CookieManager;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.Toast;

import org.apache.http.util.EncodingUtils;

public class CallUrlActivity extends AppCompatActivity {

    WebView wb;
    String url="http://enquiry.airbil.in/employee-login";
    String mobile_no="",password="";
    String post_data="";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        requestWindowFeature(Window.FEATURE_NO_TITLE);
        getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN,
                WindowManager.LayoutParams.FLAG_FULLSCREEN);
        setContentView(R.layout.activity_call_url);

        mobile_no=getIntent().getExtras().getString("mobile_no");
        password=getIntent().getExtras().getString("password");
        post_data="mobile_no="+mobile_no+"&password="+password;

        wb=(WebView)findViewById(R.id.wb);
        WebSettings webSettings = wb.getSettings();
        webSettings.setJavaScriptEnabled(true);
        webSettings.setJavaScriptCanOpenWindowsAutomatically(true);
        wb.setWebViewClient(new MyCustomWebViewClient());
        wb.setScrollBarStyle(View.SCROLLBARS_INSIDE_OVERLAY);
        NetworkInfo info = (NetworkInfo) ((ConnectivityManager)
                getApplicationContext().getSystemService(Context.CONNECTIVITY_SERVICE)).getActiveNetworkInfo();

        if (info == null)
        {
            Intent i=new Intent(getApplicationContext(),PageNotFoundActivity.class);
            startActivity(i);

        }else {

            wb.postUrl(url,post_data.getBytes());
//            wb.loadUrl(url);
//            wb.postUrl(url, EncodingUtils.getBytes(post_data, "BASE64"));
//            String cookies= CookieManager.getInstance().getCookie(url);
//            Toast.makeText(getApplicationContext(),"Cookies are :-"+cookies,Toast.LENGTH_LONG).show();
        }
    }


    private class MyCustomWebViewClient extends WebViewClient {
        @Override
        public boolean shouldOverrideUrlLoading(WebView view, String url) {
            view.loadUrl(url);
            return true;
        }
    }
}
