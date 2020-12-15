package com.example.otp;

import android.app.Activity;
import android.content.Context;
import android.content.SharedPreferences;

public class SharedPreferencesUtil {

    private SharedPreferences pref;
    private Context mContext;
    private static final String XML_FILE_NAME = "File Name"; // SharedPreferences xml file name.

    public SharedPreferencesUtil(Context mContext) {
        this.mContext = mContext;
    }


    public String getSharedString(String key) {
        pref = mContext.getSharedPreferences(XML_FILE_NAME, Activity.MODE_PRIVATE);
        String json = pref.getString(key, null);
        return json;
    }


    public void setSharedString(String key, String json) {
        pref = mContext.getSharedPreferences(XML_FILE_NAME, Activity.MODE_PRIVATE);
        SharedPreferences.Editor editor = pref.edit();
        editor.putString(key, json);
        editor.commit();

    }

    public void delShared(String key) {
        pref = mContext.getSharedPreferences(XML_FILE_NAME, Activity.MODE_PRIVATE);
        SharedPreferences.Editor editor = pref.edit();
        editor.remove(key);
        editor.commit();
    }

}
