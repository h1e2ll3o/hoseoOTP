package com.example.otp;

import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;

import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.toolbox.Volley;

import org.json.JSONException;
import org.json.JSONObject;

public class SMSRandomNumberActivity extends AppCompatActivity {

    private BackPressCloseHandler backKeyClickHandler;
    private EditText ERN;

    @Override
    public void onBackPressed() {
        // super.onBackPressed();
        // backKeyClickHandler.onBackPressed();
        AlertDialog.Builder builder = new AlertDialog.Builder(SMSRandomNumberActivity.this);
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
        setContentView(R.layout.activity_smsrandom_number);
        // backKeyClickHandler = new BackPressCloseHandler(this);

        ERN = findViewById(R.id.RandomNumber);


        Button okB = (Button) findViewById(R.id.RandomNumberOk);


        okB.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View view) {

                String userRN = ERN.getText().toString();

                Intent intent = getIntent();
                String userID = intent.getStringExtra("userID");
                String userPassword = intent.getStringExtra("userPassword");
                String userUUID = intent.getStringExtra("userUUID");
                String userCP = intent.getStringExtra("userCP");



/*
                if(userRN .getBytes().length <= 0) {
                    Toast.makeText(SMSRandomNumberActivity.this, "문자로 받은 코드를 입력하세요.", Toast.LENGTH_SHORT).show();
                }


 */

                Response.Listener<String> responseListener = new Response.Listener<String>() {
                    @Override
                    public void onResponse(String response) {
                        try {
                            JSONObject jsonObject = new JSONObject(response);
                            String success = jsonObject.getString("success");

                            if(success.equals("EmptyRN")) {

                                AlertDialog.Builder builder = new AlertDialog.Builder(SMSRandomNumberActivity.this);
                                builder.setTitle("").setMessage("코드를 입력해주세요.")
                                        .setPositiveButton("확인", new DialogInterface.OnClickListener() {

                                            public void onClick(DialogInterface dialog, int i) {
                                                dialog.cancel();
                                            }
                                        });
                                AlertDialog alert = builder.create();
                                alert.setTitle("");
                                alert.show();

                            } else if(success.equals("RNfalse")) {

                                AlertDialog.Builder builder = new AlertDialog.Builder(SMSRandomNumberActivity.this);
                                builder.setTitle("").setMessage("코드가 일치하지 않습니다.")
                                        .setPositiveButton("확인", new DialogInterface.OnClickListener() {

                                            public void onClick(DialogInterface dialog, int i) {
                                                dialog.cancel();
                                            }
                                        });
                                AlertDialog alert = builder.create();
                                alert.setTitle("");
                                alert.show();

                            } else if (success.equals("RNOk")) {
/*
                                AlertDialog.Builder builder = new AlertDialog.Builder(SMSRandomNumberActivity.this);
                                builder.setTitle("").setMessage("코드 인증이 완료되었습니다.")
                                        .setPositiveButton("확인", new DialogInterface.OnClickListener() {

                                            public void onClick(DialogInterface dialog, int i) {
                                                dialog.cancel();

                                            }
                                        });
                                AlertDialog alert = builder.create();
                                alert.setTitle("");
                                alert.show();



 */


                                    String userID = jsonObject.getString("userID");
                                    String userPass = jsonObject.getString("userPassword");
                                    String userName = jsonObject.getString("userName");
                                    String userAge = jsonObject.getString("userAge");
                                    String userUUID = jsonObject.getString("userUUID");
                                    String userCP = jsonObject.getString("userCP");
                                    String userRN = jsonObject.getString("userRN");


                                    // Toast.makeText( getApplicationContext(), "코드 저장 성공", Toast.LENGTH_SHORT ).show();
                                    Intent intent = new Intent(SMSRandomNumberActivity.this, CreatedOTPActivity.class);


                                    intent.putExtra("userID", userID);
                                    intent.putExtra("userPassword", userPass);
                                    intent.putExtra("userName", userName);
                                    intent.putExtra("userAge", userAge);
                                    intent.putExtra("userUUID", userUUID);
                                    intent.putExtra("userCP", userCP);
                                    intent.putExtra("userRN", userRN);


                                    startActivity(intent);
                                    SMSRandomNumberActivity.this.finish();

                            }




                            else {
                                Toast.makeText( getApplicationContext(), "코드 확인 실패", Toast.LENGTH_SHORT ).show();
                                Toast.makeText( getApplicationContext(), success, Toast.LENGTH_SHORT ).show();
                                return;
                            }

                        } catch (JSONException e) {
                            e.printStackTrace();
                        }
                    }
                };
                CheckRNRequest checkRNRequest = new CheckRNRequest( userRN, userID, userPassword, responseListener );
                RequestQueue queue = Volley.newRequestQueue( SMSRandomNumberActivity.this );
                queue.add( checkRNRequest );



                //startActivity(new Intent(SMSRandomNumberActivity.this, CreatedOTPActivity.class));





            }











        });




    }
}
