package com.grp4.loginsystem.user;
 
import java.util.List;
 
import com.grp4.loginsystem.user.entity.User;
 
public interface UserDao {
 
    void add(User user);
 
    void update(User user);
 
    void delete(User user);
 
    List findAll();
 
    List findById(int id);
 
    List findByUsername(String username);
}