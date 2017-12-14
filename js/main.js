
const profileModal = document.getElementById('profileModal');
const profileModalBtn = document.getElementById('openProfileModal');
const closeProfileModal = document.getElementById('closeProfileModal');
const indexMain = document.querySelector('body');


const modal = document.querySelectorAll('.modal');



profileModalBtn.addEventListener('click', () => {
    profileModal.style.animationName ='slideIn';
    modal[0].style.animationName = 'fadeIn';
    modal[0].style.display = "block";
    indexMain.style.overflow = 'hidden';

});

closeProfileModal.addEventListener('click', () => {
    setTimeout( () => {
        modal[0].style.display = "none";
        indexMain.style.overflow = 'auto';
        profileModal.style.animationName ='slideIn';
    }, 380);
    profileModal.style.animationName ='slideOut';
    modal[0].style.animationName = 'fadeOut'
});

window.addEventListener('click', (evt) => {
    if (evt.target === modal[0]){
        setTimeout( () => {
            modal[0].style.display = "none";
            indexMain.style.overflow = 'auto';
            profileModal.style.animationName ='slideIn';
            modal[0].style.animationName = 'fadeIn'
        }, 380);
        profileModal.style.animationName ='slideOut';
        modal[0].style.animationName = 'fadeOut'
    }
});

const editProfileBtn = document.getElementById('editProfileBtn');
const editProfile = document.getElementById('editProfile');
const searchAndProfile = document.getElementById('searchAndProfile');

editProfileBtn.addEventListener('click', () => {
  editProfile.style.display = "flex";
    searchAndProfile.style.display = "none";
    editProfileBtn.style.display = "none";
});


const makePostModal = document.getElementById('makePostModal');
const postModalBtn = document.getElementById('openMakePostModal');
const closePostModal = document.getElementById('closePostModal');






postModalBtn.addEventListener('click', () => {
    makePostModal.style.animationName ='slideInR';
    modal[1].style.animationName = 'fadeIn';
    modal[1].style.display = "block";
    indexMain.style.overflow = 'hidden';
});

closePostModal.addEventListener('click', () => {
    setTimeout( () => {
        modal[1].style.display = "none";
        indexMain.style.overflow = 'auto';
        makePostModal.style.animationName ='slideInR';
    },380);
    makePostModal.style.animationName ='slideOutR';
    modal[1].style.animationName = 'fadeOut'

});

window.addEventListener('click', (evt) => {
    if (evt.target === modal[1]){
        setTimeout( () => {
            modal[1].style.display = "none";
            indexMain.style.overflow = 'auto';
            makePostModal.style.animationName ='slideInR';
        }, 380);
        makePostModal.style.animationName ='slideOutR';
        modal[1].style.animationName = 'fadeOut'
    }
});

const postit = document.querySelectorAll('.postsBox');


postit.forEach((post, i) => {
  let playbtn = post.querySelector('.playbtn');
  let audio = post.querySelector('audio');
  let pausebtn = post.querySelector('.pausebtn');
  let counter = post.querySelector('.counter');
  let showMore = post.querySelector('.postFooter');
  let fullPost = post.querySelector('.fullPostModal');
  let comments = document.querySelector('.comments');
    let date = post.querySelector('.dateBreak');


    if ((i <= postit.length) && i-1 > 0){
        if(postit[i].querySelector('.postDate').innerHTML !== postit[i-1].querySelector('.postDate').innerHTML){
            console.log(postit[i].querySelector('.postDate').innerHTML);

            date.innerHTML = postit[i].querySelector('.postDate').innerHTML;
        }
    } else if(i === 0){
        console.log(postit[i].querySelector('.postDate').innerHTML);
        date.innerHTML = postit[i].querySelector('.postDate').innerHTML;
    }



  playbtn.addEventListener('click', () => {
   audio.play();
   playbtn.style.display = 'none';
   pausebtn.style.display = 'flex';
   counter.style.display = 'flex';
  });
  pausebtn.addEventListener('click', () => {
   audio.pause();
   playbtn.style.display = 'flex';
   pausebtn.style.display = 'none';
  });
  showMore.addEventListener('click', () => {
    fullPost.classList.toggle('modalHidden');

  });
  audio.addEventListener('ended' , () => {
   playbtn.style.display = 'flex';
   pausebtn.style.display = 'none';
   counter.style.display = 'none';
  });
  audio.addEventListener('timeupdate', () => {
     counter.innerText = Math.trunc(audio.duration - audio.currentTime +0.99) + 's';
  });



  

  //console.log(audio.duration);


 });










