document.addEventListener('DOMContentLoaded', function () {
    var home = document.getElementById('home');
    var profile = document.getElementById('profile');
    var notifications = document.getElementById('notifications');
    var messages = document.getElementById('messages');
    var settings = document.getElementById('settings');
    var followbutton = document.querySelectorAll('.follow-button');
    var followContainer = document.querySelectorAll('.follower-container')
    var gestoContainer = document.getElementById('inner-main-content')
    var popupOuter = document.getElementById('popup-outer')
    var popupInner = document.getElementById('popup-inner')
    var popupOuter2 = document.getElementById('popup-outer-2')
    var popupInner2 = document.getElementById('popup-inner-2')
    var messageList = document.getElementById('listofmessages')
    
    popupOuter.classList.add('remove')
    popupOuter2.classList.add('remove')

    document.addEventListener('click', function (event) {
        if (event.target && event.target.classList.contains('comment-click') || event.target.classList.contains('comment-parent-click')) {
             console.log(event.target.closest('.comment-parent-click').getAttribute('data-post-id'));
            fetch('http://localhost/gesto/comments_handler/comments.php', {
                method: 'POST',
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: "innercommentsclickid=" + event.target.closest('.comment-parent-click').getAttribute('data-comment-id') + "&postID=" + event.target.closest('.comment-parent-click').getAttribute('data-post-id'),
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Network response was not ok");
                    }
                    return response.text();
                })
                .then(responseText => {
                    gestoContainer.innerHTML = responseText;
                })
                .catch(error => {
                    console.error("There was a problem with the fetch operation:", error);
                });
        }
    })
    

    document.addEventListener('click', function (event) {
        if (event.target && event.target.classList.contains('show-more') || event.target.classList.contains('show-more-color')) {
            fetch('http://localhost/gesto/comments_handler/inner_comments.php', {
                method: 'POST',
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body : "commentid=" + event.target.closest('.show-more').getAttribute('data-comment-id') + "&postID=" + event.target.closest('.show-more').getAttribute('data-post-id'),
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.text();
            })
            .then(responseText => {
                if (event.target.classList.contains('show-more-color')) {
                    event.target.closest('.show-more').innerHTML = responseText
                } else {
                    event.target.innerHTML = responseText
                }
            })
            .catch(error => {
                console.error("There was a problem with the fetch operation:", error);
            });
            
        }
    })


    // Posts Likes Functionality
    document.addEventListener('click', function (event) {
        if (event.target && event.target.classList.contains('post-like')) {
            if (event.target.classList.contains('fa-regular')) {
                event.target.classList.remove('fa-regular')
                event.target.classList.add('fa-solid')
                var likenumber = event.target.nextElementSibling
                console.log(likenumber.textContent)
                var num = parseInt(likenumber.textContent, 10)
                if (likenumber.textContent == '') {
                    likenumber.textContent = 1;
                } else {
                    likenumber.textContent = num + 1;
                }
                fetch('http://localhost/gesto/assests/actions.php', {
                    method: 'POST',
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body : "likepostid=" + event.target.getAttribute('data-post-id'),
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Network response was not ok");
                    }
                    return response.text();
                })
                .catch(error => {
                    console.error("There was a problem with the fetch operation:", error);
                });
            } else {
                event.target.classList.add('fa-regular')
                event.target.classList.remove('fa-solid')
                var likenumber = event.target.nextElementSibling
                console.log(likenumber.textContent)
                var num = parseInt(likenumber.textContent, 10)
                if (parseInt(likenumber.textContent, 10) == 1) {
                    likenumber.textContent = '';
                } else {
                    likenumber.textContent = num - 1;
                }
                fetch('http://localhost/gesto/assests/actions.php', {
                    method: 'POST',
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body : "unlikepostid=" + event.target.getAttribute('data-post-id'),
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Network response was not ok");
                    }
                    return response.text();
                })
                .catch(error => {
                    console.error("There was a problem with the fetch operation:", error);
                });
           }
        }
    })

    //Comment Likes Functionality
    document.addEventListener('click', function (event) {
        if (event.target && event.target.classList.contains('comment-like')) {
            if (event.target.classList.contains('fa-regular')) {
                event.target.classList.remove('fa-regular')
                event.target.classList.add('fa-solid')
                console.log(event.target.getAttribute('data-comment-id'));
                var likenumber = event.target.nextElementSibling
                var num = parseInt(likenumber.textContent, 10)
                if (likenumber.textContent == '') {
                    likenumber.textContent = 1;
                } else {
                    likenumber.textContent = num + 1;
                }
                fetch('http://localhost/gesto/assests/actions.php', {
                    method: 'POST',
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body : "likecommentid=" + event.target.getAttribute('data-comment-id'),
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Network response was not ok");
                    }
                    return response.text();
                })
                .catch(error => {
                    console.error("There was a problem with the fetch operation:", error);
                });
            } else {
                event.target.classList.add('fa-regular')
                event.target.classList.remove('fa-solid')
                var likenumber = event.target.nextElementSibling
                var num = parseInt(likenumber.textContent, 10)
                if (parseInt(likenumber.textContent, 10) == 1) {
                    likenumber.textContent = '';
                } else {
                    likenumber.textContent = num - 1;
                }
                fetch('http://localhost/gesto/assests/actions.php', {
                    method: 'POST',
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                    body : "unlikecommentid=" + event.target.getAttribute('data-comment-id'),
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Network response was not ok");
                    }
                    return response.text();
                })
                .catch(error => {
                    console.error("There was a problem with the fetch operation:", error);
                });
           }
        }
    })

    document.addEventListener('click', function (event) {
        if (event.target && event.target.classList.contains('home-comment')) {
            console.log(event.target.getAttribute('data-post-id'))
            console.log(event.target.getAttribute('data-comment-id'))
            fetch('http://localhost/gesto/popup/comment.php', {
                method: 'POST',
                    headers: {
                         "Content-Type": "application/x-www-form-urlencoded",
                },
                body : "postID=" + event.target.getAttribute('data-post-id'),
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.text();
            })
            .then(responseText => {
                popupInner.innerHTML = responseText
                popupOuter.classList.remove('remove')
                popupInner.classList.add('show')

                popupOuter.addEventListener('click', function () {
                    popupOuter.classList.remove('show')
                    popupOuter.classList.add('remove')
                })

                
                popupInner.addEventListener('click', function (event) {
                    event.stopPropagation();
                })

                document.getElementById("profile-cross-button").addEventListener("click", function () {
                    popupOuter.classList.remove("show");
                    popupOuter.classList.add("remove");
                });

            })
            .catch(error => {
                console.error("There was a problem with the fetch operation:", error);
            });
        }
    })

    document.addEventListener('click', function (event) {
        if (event.target && event.target.classList.contains('inside-comment')) {
            console.log(event.target.getAttribute('data-post-id'))
            console.log(event.target.getAttribute('data-comment-id'))
            fetch('http://localhost/gesto/popup/post-comments.php', {
                method: 'POST',
                    headers: {
                         "Content-Type": "application/x-www-form-urlencoded",
                },
                body : "commentID="  + event.target.getAttribute('data-comment-id') + "&postID=" + event.target.getAttribute('data-post-id'),
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.text();
            })
            .then(responseText => {
                popupInner.innerHTML = responseText
                popupOuter.classList.remove('remove')
                popupInner.classList.add('show')

                popupOuter.addEventListener('click', function () {
                    popupOuter.classList.remove('show')
                    popupOuter.classList.add('remove')
                })

                
                popupInner.addEventListener('click', function (event) {
                    event.stopPropagation();
                })

                document.getElementById("profile-cross-button").addEventListener("click", function () {
                    popupOuter.classList.remove("show");
                    popupOuter.classList.add("remove");
                });

            })
            .catch(error => {
                console.error("There was a problem with the fetch operation:", error);
            });
        }
    })

    // Follow Button Functionality
    followContainer.forEach(container => {
        container.addEventListener('click', function () {
            var containerFollowerName = container.getAttribute('data-id');
            gesto_followers(containerFollowerName)
        })
    })

    // Follow Button Functionality
    followbutton.forEach(fButton => {
        fButton.addEventListener('click', function (event) {
            event.stopPropagation();
            var followerID = fButton.getAttribute('data-id');
            fetch('http://localhost/gesto/assests/actions.php', {
                method: 'POST',
                headers: {
                     "Content-Type": "application/x-www-form-urlencoded",
                },
                body: "dataId=" + followerID,
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.text();
            })
            .then(data => {
                fButton.textContent = data;
            })
            .catch(error => {
                console.error("There was a problem with the fetch operation:", error);
            });
        })
    });



       
    profile.addEventListener('click', function () {
        fetch('http://localhost/gesto/assests/actions.php', {
            method: 'POST',
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: "mainuserid=" + "1",
        }).then(response => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.text();
        }).then(data => {
            gesto_profile(data);
        }).catch(error => {
            console.error("There was a problem with the fetch operation:", error);
        });
    })

    home.addEventListener('click', function () {
        gesto_home();
    })

    notifications.addEventListener('click', function () {
        gesto_notification();
    })

    messages.addEventListener('click', function () {
        gesto_messages();
    })

    settings.addEventListener('click', function () {
        gesto_settings();
    })

    
    const profile_pattern = /^\/gesto\/\w+$/;
    const replies_pattern = /^\/gesto\/(\w+)\/replies$/;
    const likes_pattern = /^\/gesto\/(\w+)\/likes$/;

    if (window.location.pathname == '/gesto/home') {
        gesto_home();
    } else if (window.location.pathname == '/gesto/messages') {
        gesto_messages();
    } else if (window.location.pathname == '/gesto/notifications') {
        gesto_notification();
    } else if (window.location.pathname == '/gesto/settings') {
        gesto_settings();
    } else if (replies_pattern.test(window.location.pathname) || likes_pattern.test(window.location.pathname) || profile_pattern.test(window.location.pathname)) {
       gettingUsername()
    }

    document.addEventListener('click', function(event){
        if (event.target && event.target.classList.contains('posts')) {
           clickOnPost(event.target.closest('.parent').getAttribute('data-gesto-post-id') , event.target.closest('.parent').getAttribute('data-gesto-post-username'))
        }
    })

    function clickOnPost(id, username) {
        history.pushState(null, "", `/gesto/${username}/${id}`);
         fetch('http://localhost/gesto/posts/edit-other-posts.php', {
                method: 'POST',
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body : "postID=" + id,
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.text();
            })
                .then(responseText => {
                gestoContainer.innerHTML = responseText
            })    
            .catch(error => {
                console.error("There was a problem with the fetch operation:", error);
            });
    }


    function gettingUsername() {

        fetch('http://localhost/gesto/assests/actions.php', {
            method: 'POST',
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: "mainuserid=" + "1",
        }).then(response => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            return response.text();
        }).then(data => {
   
            var username_from_url = window.location.pathname
            var username = username_from_url.split('/').filter(Boolean)
            if (username[1] == data) {
                gesto_profile(data);
            } else {
                gesto_followers(username[1]);
            }
        }).catch(error => {
            console.error("There was a problem with the fetch operation:", error);
        });

    }

    function gesto_followers(followerUsername) {

        fetch('http://localhost/gesto/follower_details/follower_account.php' ,{
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body :  "followerID=" + followerUsername,
        })
        .then((response) => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.text();
        })
        .then((responseText) => {
            document.getElementById('inner-main-content').innerHTML = responseText;
            var posts = document.getElementById('posts');
            var replies = document.getElementById('replies');
            var likes = document.getElementById('likes');
            var followbutton2 = document.getElementById('follow-button-2')
            var messageBox = document.getElementById('message-box')

            messageBox.addEventListener('click', function () {
                var followerIDForMessage = messageBox.getAttribute('data-id')
                fetch("http://localhost/gesto/assests/actions.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded",
                    },
                        body : "messagefollowerID=" + followerIDForMessage
                    })
                    .then((response) => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! Status: ${response.status}`);
                        }
                            return response.text();
                        })
                    .then((responseText) => {
                        gesto_messages(followerIDForMessage);
                    })
                    .catch((error) => {
                        console.error("Fetch error:", error);
                    });
               
            })


            followbutton2.addEventListener('click', function () {
            var followerID = followbutton2.getAttribute('data-id');
            fetch('http://localhost/gesto/assests/actions.php', {
                method: 'POST',
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
            },
                body: "dataId=" + followerID,
            })
            .then(response => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
                return response.text();
            })
            .then(data => {
                followbutton2.textContent = data;
            })
            .catch(error => {
                console.error("There was a problem with the fetch operation:", error);
            });
        })

            posts.addEventListener('click', function () {
                gesto_posts();
            })

            replies.addEventListener('click', function () {
                gesto_replies();
            })

            likes.addEventListener('click', function () {
                gesto_likes();
            })
            

            const profile_pattern = /^\/gesto\/\w+$/;
            const replies_pattern = /^\/gesto\/(\w+)\/replies$/;
            const likes_pattern = /^\/gesto\/(\w+)\/likes$/;

                    
            if (replies_pattern.test(window.location.pathname)) {
                gesto_replies();
            } else if (likes_pattern.test(window.location.pathname)) {
                gesto_likes();
            }else if (profile_pattern.test(window.location.pathname)) {
                gesto_posts();
            }

            function gesto_posts() {
                            
                fetch(`http://localhost/gesto/follower_profile/posts.php?followerusername=${followerUsername}` , {
                    method: "GET",
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                    },
                
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! Status: ${response.status}`);
                        }
                        return response.text();
                    })
                    .then(responseText => {
                        document.getElementById('posts-inner-content').innerHTML = responseText
                        posts.style.backgroundColor = 'rgb(204, 204, 204, 0.2)'
                        replies.style.backgroundColor = ''
                        likes.style.backgroundColor = ''


                            
                    })
                    .catch(error => {
                        console.error("Fetch error:", error);
                    })
            history.pushState(null, "", `/gesto/${followerUsername}`);
            document.title = 'GESTO / Profile'
            }
                   

                    

            function gesto_replies() {
                            
                fetch('http://localhost/gesto/follower_profile/replies.php', {
                    method: "GET",
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                    },
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! Status: ${response.status}`);
                        }
                        return response.text();
                    })
                    .then(responseText => {
                        document.getElementById('posts-inner-content').innerHTML = responseText
                        posts.style.backgroundColor = ''
                        replies.style.backgroundColor = 'rgb(204, 204, 204, 0.2)'
                        likes.style.backgroundColor = ''
                            
                    })
                    .catch(error => {
                        console.error("Fetch error:", error);
                    })
            history.pushState(null, "", `/gesto/${followerUsername}/replies`);
            document.title = 'GESTO / Replies'
            }
                   

                    
            function gesto_likes() {
                            
                fetch('http://localhost/gesto/follower_profile/likes.php', {
                    method: "GET",
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                    },
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! Status: ${response.status}`);
                        }
                        return response.text();
                    })
                    .then(responseText => {
                        document.getElementById('posts-inner-content').innerHTML = responseText
                        likes.style.backgroundColor = 'rgb(204, 204, 204, 0.2)'
                        posts.style.backgroundColor = ''
                        replies.style.backgroundColor = ''
                            
                            
                    })
                    .catch(error => {
                        console.error("Fetch error:", error);
                    })
            history.pushState(null, "", `/gesto/${followerUsername}/likes`);
            document.title = 'GESTO / Likes'
            }

        })
        .catch(error => {
            console.error("Fetch error:", error);
        })
    }


    function gesto_profile(mainusername) {
        
            fetch('http://localhost/gesto/content/profile.php', {
                method: "GET",
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                },
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.text();
                })
                .then((responseText) => {
                    document.getElementById('inner-main-content').innerHTML = responseText;
                    var posts = document.getElementById('posts');
                    var replies = document.getElementById('replies');
                    var likes = document.getElementById('likes');      
                    profile.style.borderRadius = '3px'
                    profile.style.borderTopLeftRadius = '20px'
                    profile.style.borderTopRightRadius = '20px'
                    profile.style.borderBottomLeftRadius = '20px'
                    profile.style.borderBottomRightRadius = '20px'



                    posts.addEventListener('click', function () {
                        gesto_posts();
                    })

                    replies.addEventListener('click', function () {
                        gesto_replies();
                    })

                    likes.addEventListener('click', function () {
                        gesto_likes();
                    })

     
                    const profile_pattern = /^\/gesto\/\w+$/;
                    const replies_pattern = /^\/gesto\/(\w+)\/replies$/;
                    const likes_pattern = /^\/gesto\/(\w+)\/likes$/;

                    
                    if (replies_pattern.test(window.location.pathname)) {
                        gesto_replies();
                    } else if (likes_pattern.test(window.location.pathname)) {
                        gesto_likes();
                    }else if (profile_pattern.test(window.location.pathname)) {
                        gesto_posts();
                    }

                    function gesto_posts() {
                            
                            fetch('http://localhost/gesto/gesto_profile/posts.php', {
                                method: "GET",
                                headers: {
                                    "X-Requested-With": "XMLHttpRequest",
                                },
                            })
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error(`HTTP error! Status: ${response.status}`);
                                    }
                                    return response.text();
                                })
                                .then(responseText => {
                                    document.getElementById('posts-inner-content').innerHTML = responseText
                                    posts.style.backgroundColor = 'rgb(204, 204, 204, 0.2)'
                                    replies.style.backgroundColor = ''
                                    likes.style.backgroundColor = ''

                            
                                })
                                .catch(error => {
                                    console.error("Fetch error:", error);
                                })
                        history.pushState(null, "", `/gesto/${mainusername}`);
                        document.title = 'GESTO / Profile'
                        }
                   

                    

                    function gesto_replies() {
                            
                            fetch('http://localhost/gesto/gesto_profile/replies.php', {
                                method: "GET",
                                headers: {
                                    "X-Requested-With": "XMLHttpRequest",
                                },
                            })
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error(`HTTP error! Status: ${response.status}`);
                                    }
                                    return response.text();
                                })
                                .then(responseText => {
                                    document.getElementById('posts-inner-content').innerHTML = responseText
                                    posts.style.backgroundColor = ''
                                    replies.style.backgroundColor = 'rgb(204, 204, 204, 0.2)'
                                    likes.style.backgroundColor = ''
                            
                                })
                                .catch(error => {
                                    console.error("Fetch error:", error);
                                })
                        history.pushState(null, "", `/gesto/${mainusername}/replies`);
                        document.title = 'GESTO / Replies'
                        }
                   

                    
                    function gesto_likes() {
                            
                            fetch('http://localhost/gesto/gesto_profile/likes.php', {
                                method: "GET",
                                headers: {
                                    "X-Requested-With": "XMLHttpRequest",
                                },
                            })
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error(`HTTP error! Status: ${response.status}`);
                                    }
                                    return response.text();
                                })
                                .then(responseText => {
                                    document.getElementById('posts-inner-content').innerHTML = responseText
                                    likes.style.backgroundColor = 'rgb(204, 204, 204, 0.2)'
                                    posts.style.backgroundColor = ''
                                    replies.style.backgroundColor = ''
                            
                            
                                })
                                .catch(error => {
                                    console.error("Fetch error:", error);
                                })
                        history.pushState(null, "", `/gesto/${mainusername}/likes`);
                        document.title = 'GESTO / Likes'
                        }


                
                    // Popup display functionality
                    var editProfile = document.getElementById('edit-profile');
                    editProfile.addEventListener('click', function () {
                        popupOuter.classList.remove('remove')
                        popupOuter.classList.add('show')

                        fetch("http://localhost/gesto/popup/edit-profile.php", {
                            method: "GET",
                            headers: {
                                "X-Requested-With": "XMLHttpRequest",
                            },
                        })
                            .then((response) => {
                                if (!response.ok) {
                                    throw new Error(`HTTP error! Status: ${response.status}`);
                                }
                                return response.text();
                            })
                            .then((responseText) => {
                                popupInner.innerHTML = responseText;
                                document.getElementById("profile-cross-button").addEventListener("click", function () {
                                    popupOuter.classList.remove("show");
                                    popupOuter.classList.add("remove");
                                });
                                var profilePictureSetup = document.getElementsByClassName('profile-picture-main')
                                var profileImageInput = document.getElementsByClassName('imageinput')
                                var formData = new FormData()


                                profileImageInput[0].addEventListener('change', function () {
                                    popupOuter2.classList.remove('remove')
                                    popupOuter2.classList.add('show')
                                    var file = profileImageInput[0].files[0]
                                    if (file) {
                                        var reader = new FileReader()
                                        reader.onload = function (e) {

                                            var binaryData = atob(e.target.result.split(',')[1]);
                                            var uint8Array = new Uint8Array(binaryData.length);
                                            var cropper
                                            for (var i = 0; i < binaryData.length; i++) {
                                                uint8Array[i] = binaryData.charCodeAt(i);
                                            }
                                            var blob = new Blob([uint8Array], { type: 'image/*' });
                                            formData.append('image', blob)
                                            
                                            
                                            fetch('http://localhost/gesto/popup/edit-profile-picture.php', {
                                                method: "POST",
                                                body : formData
                                            })
                                            .then((response) => {
                                                if (!response.ok) {
                                                    throw new Error(`HTTP error! Status: ${response.status}`);
                                                }
                                                return response.text();
                                            })
                                            .then((responseText) => {
                                                popupInner2.innerHTML = responseText
                                                var cropedPicture = document.getElementsByClassName('profile-picture-edits')
                                                var saveButtton = document.getElementsByClassName('profile-picture-save-button')

                                                cropper = new Cropper(cropedPicture[0], {
                                                    aspectRatio: 1,
                                                })

                                                saveButtton[0].addEventListener('click', function () {
                                                    popupOuter2.classList.remove('show')
                                                    popupOuter2.classList.add('remove')

                                                    var imageCropped = cropper.getCroppedCanvas()
                                                    console.log(imageCropped)
                                                    var imageuri = imageCropped.toDataURL("image/jpeg");
                                                    profilePictureSetup[0].src = imageuri

                                                    // Converting dataUri to binary to store in the database
                                                    const parts = imageuri.split(',');
                                                    const contentType = parts[0].match(/:(.*?);/)[1];
                                                    const data = parts[1];
                                                    const decodedData = atob(data);
                                                    const byteCharacters = new Uint8Array(decodedData.length);
                                                    for (let i = 0; i < decodedData.length; i++) {
                                                        byteCharacters[i] = decodedData.charCodeAt(i);
                                                    }
                                                    const base64Data = btoa(String.fromCharCode.apply(null, byteCharacters));
                                                    document.getElementById('binarydataofimage').value = base64Data;
                                                    document.getElementById('imagetype').value = contentType;

                                                })



                                            })
                                             .catch((error) => {
                                                console.error("Fetch error:", error);
                                            });
                                            
                                        }
                                        reader.readAsDataURL(file)
                                    }

                                    popupOuter2.addEventListener('click', function () {
                                        popupOuter2.classList.remove('show')
                                        popupOuter2.classList.add('remove')
                                    })

                                
                                    popupInner2.addEventListener('click', function (event) {
                                        event.stopPropagation();
                                    })

                                })                        
                            })
                            .catch((error) => {
                                console.error("Fetch error:", error);
                            });

                    
                    })

                    popupOuter.addEventListener('click', function () {
                        popupOuter.classList.remove('show')
                        popupOuter.classList.add('remove')
                    })

                
                    popupInner.addEventListener('click', function (event) {
                        event.stopPropagation();
                    })
            
                })
                .catch(error => {
                    console.error("Fetch error:", error);
                })
        
       
        }
        
    
    function gesto_home() {
            fetch("http://localhost/gesto/content/home.php", {
                method: "GET",
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                },
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.text();
                })
                .then((responseText) => {
                    document.getElementById("inner-main-content").innerHTML = responseText;
                    home.style.borderRadius = "3px";
                    home.style.borderTopLeftRadius = '20px'
                    home.style.borderTopRightRadius = '20px'
                    home.style.borderBottomLeftRadius = '20px'
                    home.style.borderBottomRightRadius = '20px'



                    
                })
                .catch((error) => {
                    console.error("Fetch error:", error);
                });
            
        history.pushState(null, "", '/gesto/home');
        document.title = 'GESTO / Home'
        }
    
    function gesto_notification() {
            fetch("http://localhost/gesto/content/notifications.html", {
                method: "GET",
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                },
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.text(); // Use text() to get the response as text
                })
                .then((responseText) => {
                    document.getElementById("inner-main-content").innerHTML = responseText;

                    notifications.style.borderRadius = "3px";
                    notifications.style.borderTopLeftRadius = '20px'
                    notifications.style.borderTopRightRadius = '20px'
                    notifications.style.borderBottomLeftRadius = '20px'
                    notifications.style.borderBottomRightRadius = '20px'

                })
                .catch((error) => {
                    console.error("Fetch error:", error);
                });
        history.pushState(null, "", '/gesto/notifications');
        document.title = 'GESTO / Notifications'
        }

    
    function gesto_messages(msgFollowerID = "") {
        console.log(msgFollowerID)
        var conversationIDInput
        

            /* 
            Getting the list of messages
            */
            fetch("http://localhost/gesto/content/message-list.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body : 'msgFollowerID=' + msgFollowerID
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.text();
                })
                .then((responseText) => {
                    messageList.innerHTML = responseText; 
                    document.addEventListener('click', function (event) { 
                        if (event.target && event.target.classList.contains('msg')) {
                            var conversationID = event.target.closest('.msg-parent').getAttribute('data-conversation-id')
                            var followerID = event.target.closest('.msg-parent').getAttribute('data-follower-id')
                            getMessages(conversationID , followerID)                         
                        }
                    })
                    
                })
                .catch((error) => {
                    console.error("Fetch error:", error);
                });

            /* 
            Message Box
            */
        getMessages()
        function getMessages(conversationID = '', followerID  = '') {
            fetch("http://localhost/gesto/content/messages.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: 'msgFollowerID=' + conversationID
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.text();
                })
                .then((responseText) => {
                    document.getElementById("inner-main-content").innerHTML = responseText;
                    var msg = document.getElementById('real-message')
                    var sendButton = document.getElementById('send-message-button')
                    var message = document.getElementById('message-to-be-sent')
                    var userID = document.getElementById('userID')
                    var id 
                    messages.style.borderRadius = "3px";
                    messages.style.borderTopLeftRadius = '20px'
                    messages.style.borderTopRightRadius = '20px'
                    messages.style.borderBottomLeftRadius = '20px'
                    messages.style.borderBottomRightRadius = '20px'


                    const conn = new WebSocket("ws://localhost:8080?userid=" + userID.value);

                    conn.onopen = function (e) {
                        console.log("Connection established!");
                    };

                    conn.onmessage = function (e) {
                        console.log(e)
                        msg.textContent = e.data
                    };

                    sendButton.addEventListener('click', function () {
                        if (followerID != '') {
                            id = followerID
                        } else {
                            id = msgFollowerID
                        }
                        var messageData = {}
                        messageData.message = message.value;
                        messageData.followerid = id;
                        messageData.conversationid = conversationID
                        var jsonMessage = JSON.stringify(messageData);
                        conn.send(jsonMessage)
                        message.value = ""
                    })

                    
                })
                .catch((error) => {
                    console.error("Fetch error:", error);
                });
        }
        history.pushState(null, "", '/gesto/messages');
        document.title = 'GESTO / Messages'
        }

    function gesto_settings() {
         
            fetch("http://localhost/gesto/content/settings.html", {
                method: "GET",
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                },
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.text();
                })
                .then((responseText) => {
                    document.getElementById("inner-main-content").innerHTML = responseText;
                    settings.style.borderTopLeftRadius = '20px'
                    settings.style.borderTopRightRadius = '20px'
                    settings.style.borderBottomLeftRadius = '20px'
                    settings.style.borderBottomRightRadius = '20px'
                })
                .catch((error) => {
                    console.error("Fetch error:", error);
                });
            
        history.pushState(null, "", '/gesto/settings');
        document.title = 'GESTO / Settings'
        }
})