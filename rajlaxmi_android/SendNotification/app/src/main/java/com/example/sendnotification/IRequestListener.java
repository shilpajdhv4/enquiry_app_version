package com.example.sendnotification;

public interface IRequestListener {

    void onComplete();

    void onError(String message);
}
