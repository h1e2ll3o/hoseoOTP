package com.example.otp;

import androidx.appcompat.app.AlertDialog;
        import androidx.appcompat.app.AppCompatActivity;

        import android.content.DialogInterface;
        import android.content.Intent;
        import android.os.Bundle;
        import android.os.Handler;
        import android.os.Message;
        import android.widget.TextView;
import android.widget.Toast;

public class LoginOkActivity extends AppCompatActivity {

    private BackPressCloseHandler backKeyClickHandler;
    private TextView getCustomerName;

    @Override
    public void onBackPressed() {
        backKeyClickHandler.onBackPressed();
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login_ok);
        backKeyClickHandler = new BackPressCloseHandler(this);

        getCustomerName = findViewById(R.id.CustomerName);

        Intent intent = getIntent();
        String userName = intent.getStringExtra("userName");
        getCustomerName.setText(userName);

        String userID = intent.getStringExtra("userID");
        String userPass = intent.getStringExtra("userPassword");
        String userUUID = intent.getStringExtra("userUUID");
        String userCP = intent.getStringExtra("userCP");

        final Intent intent2 = new Intent(LoginOkActivity.this, CreateOTPActivity.class);

        intent2.putExtra( "userID", userID);
        intent2.putExtra( "userPassword", userPass);
        intent2.putExtra( "userUUID", userUUID );
        intent2.putExtra( "userCP", userCP);


        Handler handler = new Handler() {
            public void handleMessage(Message msg) {
                super.handleMessage(msg);

                startActivity(intent2);
                LoginOkActivity.this.finish();

            }

        };
        handler.sendEmptyMessageDelayed(0, 2000);

    }
}
