package com.grp4.loginsystem.user.action;
 
import java.util.List;
 
import org.apache.log4j.Logger;
import org.springframework.beans.factory.annotation.Autowired;
 
import com.grp4.loginsystem.user.UserBo;
import com.grp4.loginsystem.user.entity.User;
import com.opensymphony.xwork2.Action;
import com.opensymphony.xwork2.Preparable;
 
public class UserAction implements Preparable {
 
    private static final Logger LOGGER = Logger.getLogger(UserAction.class.getName());
 
    private List users;
 
    private Integer id;
    private String username;
    private String password;
 
    @Autowired
    private UserBo userBo;
 
    public UserBo getUserBo() {
        return userBo;
    }
 
    public void setUserBo(UserBo userBo) {
        this.userBo = userBo;
    }
 
    public List getUsers() {
        return users;
    }
 
    public void setUsers(List users) {
        this.users = users;
    }
 
    public Integer getId() {
        return id;
    }
 
    public void setId(Integer id) {
        this.id = id;
    }
 
    public String getUsername() {
        return username;
    }
 
    public void setUsername(String username) {
        this.username = username;
    }
 
    public String getPassword() {
        return password;
    }
 
    public void setPassword(String password) {
        this.password = password;
    }
 
    public String listAll() {
        if (userBo == null) {
            return Action.ERROR;
        }
        LOGGER.debug("Get all users");
        users = userBo.findAll();
        LOGGER.debug("Users number = " + users.size());
        return Action.SUCCESS;
    }
 
    public String delete() {
        if (userBo == null) {
            return Action.ERROR;
        }
 
        User user = getUser(id);
        if (user == null) {
            return Action.ERROR;
        }
 
        LOGGER.debug("Delete user " + user.getUsername() + " with id " + user.getId());
        userBo.delete(user);
        return Action.SUCCESS;
    }
 
    public String add() {
        if (userBo == null) {
            return Action.ERROR;
        }
 
        User user = new User();
        user.setUsername(username);
        user.setPassword(password);
        LOGGER.debug("Add user: " + user.getUsername());
        userBo.add(user);
        return Action.SUCCESS;
    }
 
    public String execute() {
        return Action.SUCCESS;
    }
 
    public void prepare() throws Exception {
 
    }
 
    private User getUser(Integer id) {
        LOGGER.debug("Get user with id = " + id);
        if (id != null) {
            List users = userBo.findById(id);
            LOGGER.debug("Number of users with id = " + id + ": " + users.size());
            if (users.size() == 1) {
                return (User) users.get(0);
            }
        }
        return null;
    }
}