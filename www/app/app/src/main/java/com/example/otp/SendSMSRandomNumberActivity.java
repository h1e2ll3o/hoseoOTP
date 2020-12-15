package com.example.otp;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;

import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.telephony.SmsManager;
import android.widget.Toast;

import java.util.Random;

public class SendSMSRandomNumberActivity extends AppCompatActivity {

    private BackPressCloseHandler backKeyClickHandler;

    @Override
    public void onBackPressed() {
        // super.onBackPressed();
        // backKeyClickHandler.onBackPressed();
        AlertDialog.Builder builder = new AlertDialog.Builder(SendSMSRandomNumberActivity.this);
        builder.setMessage("정말로 종료하시겠습니까?");
        builder.setTitle("")
                .setCancelable(false)
                .setPositiveButton("네", new DialogInterface.OnClickListener() {

                    public void onClick(DialogInterface dialog, int i) {
                        finish();
                    }
                })
                .setNegativeButton("아니요", new DialogInterface.OnClickListener() {

                    public void onClick(DialogInterface dialog, int i) {
                        dialog.cancel();
                    }
                });
        AlertDialog alert = builder.create();
        alert.setTitle("");
        alert.show();
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_send_smsrandom_number);
        // backKeyClickHandler = new BackPressCloseHandler(this);

        Intent intent = getIntent();
        String userID = intent.getStringExtra("userID");
        String userPassword = intent.getStringExtra("userPassword");
        String userUUID = intent.getStringExtra("userUUID");
        String userCP = intent.getStringExtra("userCP");


        final Intent intent2 = new Intent(SendSMSRandomNumberActivity.this, SMSRandomNumberActivity.class);

        intent2.putExtra( "userID", userID );
        intent2.putExtra( "userPassword", userPassword );
        intent2.putExtra( "userUUID", userUUID );
        intent2.putExtra( "userCP", userCP);




        Handler handler = new Handler() {
            public void handleMessage(Message msg) {
                super.handleMessage(msg);



                startActivity(intent2);
                SendSMSRandomNumberActivity.this.finish();
            }
        };
        handler.sendEmptyMessageDelayed(0, 3000);
    }
}
