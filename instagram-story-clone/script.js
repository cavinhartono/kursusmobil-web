const storyList = document.getElementById("storyList");
const storyContainer = document.getElementById("storyContainer");
const storyContent = document.getElementById("storyContent");
const progressBars = document.getElementById("progressBars");
const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");
const uploadBtn = document.getElementById("uploadBtn");
const fileInput = document.getElementById("fileInput");
const titleInput = document.getElementById("titleInput");

let currentStoryGroup = 0;
let currentPostIndex = 0;
let storyDuration = 5000; // 5 seconds
let timer;
let progressFills = [];

// Default stories (you can remove these if you want user-only uploads)
let defaultStories = [
  {
    user: "John",
    posts: [
      {
        image: "https://picsum.photos/id/1011/360/640",
        title: "Adventure!",
        timestamp: Date.now() - 2 * 60 * 60 * 1000,
      },
    ],
  },
  {
    user: "Asep",
    posts: [
      {
        image: "https://picsum.photos/id/1018/360/640",
        title: "Beach Vibes",
        timestamp: Date.now() - 2 * 60 * 60 * 1000,
      },
    ],
  },
];

let stories = [];

function timeAgo(timestamp) {
  const seconds = Math.floor((Date.now() - timestamp) / 1000);
  if (seconds < 60) return `${seconds} sec ago`;
  const minutes = Math.floor(seconds / 60);
  if (minutes < 60) return `${minutes} min ago`;
  const hours = Math.floor(minutes / 60);
  if (hours < 24) return `${hours} hr ago`;
  const days = Math.floor(hours / 24);
  return `${days} day(s) ago`;
}

function loadLocalStories() {
  let localUserPosts = JSON.parse(localStorage.getItem("userStories")) || [];
  const now = Date.now();

  localUserPosts = localUserPosts.filter(
    (post) => now - post.timestamp < 24 * 60 * 60 * 1000
  );

  localStorage.setItem("userStories", JSON.stringify(localUserPosts));

  const userStoryGroup =
    localUserPosts.length > 0
      ? [
          {
            user: "You",
            posts: localUserPosts,
          },
        ]
      : [];

  return userStoryGroup;
}

function mergeStories() {
  const userStories = loadLocalStories();
  stories = [...userStories, ...defaultStories];
}

function renderStoryList() {
  mergeStories();
  storyList.innerHTML = "";

  stories.forEach((storyGroup, index) => {
    const li = document.createElement("li");

    const avatar = document.createElement("div");
    avatar.classList.add("story-avatar");

    const img = document.createElement("img");
    img.src = storyGroup.posts[0].image;

    avatar.appendChild(img);

    const label = document.createElement("span");
    label.textContent = storyGroup.user;

    li.appendChild(avatar);
    li.appendChild(label);

    li.addEventListener("click", () => {
      clearTimeout(timer);
      showStoryGroup(index, 0);
    });

    storyList.appendChild(li);
  });
}

uploadBtn.addEventListener("click", () => fileInput.click());

fileInput.addEventListener("change", (e) => {
  const file = e.target.files[0];
  if (!file) return;

  const title = titleInput.value.trim() || "Untitled";
  const reader = new FileReader();

  reader.onload = function (event) {
    const base64Image = event.target.result;

    const newPost = {
      image: base64Image,
      title: title,
      timestamp: Date.now(),
    };

    let localStories = JSON.parse(localStorage.getItem("userStories")) || [];
    localStories.unshift(newPost);

    localStorage.setItem("userStories", JSON.stringify(localStories));

    titleInput.value = ""; // clear the input field after saving

    mergeStories();
    renderStoryList();
    showStoryGroup(0, 0); // Go to "You"
  };

  reader.readAsDataURL(file);
});

function showStoryGroup(groupIndex, postIndex) {
  mergeStories();
  renderStoryList();

  if (stories.length === 0) {
    storyContent.innerHTML = `<h2>No Stories Available</h2>`;
    return;
  }

  currentStoryGroup = groupIndex;
  currentPostIndex = postIndex;

  const storyGroup = stories[currentStoryGroup];
  const posts = storyGroup.posts;

  if (currentPostIndex >= posts.length) {
    nextStoryGroup();
    return;
  }

  if (currentPostIndex < 0) {
    prevStoryGroup();
    return;
  }

  const post = posts[currentPostIndex];
  const isUser = storyGroup.user === "You";

  storyContent.style.backgroundImage = `url(${post.image})`;

  storyContent.innerHTML = `
    <div style="padding: 10px; color: white;">
      <div class="user-detail">
        <h2>${storyGroup.user}</h2>
        <p>${timeAgo(post.timestamp)}</p>
      </div>
      <p>${post.title}</p>
      ${
        isUser
          ? `<button style="margin-top:10px;" onclick="deletePost(${currentPostIndex})">Delete</button>`
          : ""
      }
    </div>
  `;

  renderProgressBars(posts.length);
  startProgressAnimation();
}

function renderProgressBars(postCount) {
  progressBars.innerHTML = "";
  progressFills = [];

  for (let i = 0; i < postCount; i++) {
    const bar = document.createElement("div");
    bar.classList.add("progress-bar");

    const fill = document.createElement("div");
    fill.classList.add("progress-bar-fill");

    if (i < currentPostIndex) {
      fill.style.width = "100%";
    }

    bar.appendChild(fill);
    progressBars.appendChild(bar);
    progressFills.push(fill);
  }
}

function startProgressAnimation() {
  progressFills[
    currentPostIndex
  ].style.transition = `width ${storyDuration}ms linear`;
  progressFills[currentPostIndex].style.width = "100%";

  clearTimeout(timer);
  timer = setTimeout(() => {
    nextPostInGroup();
  }, storyDuration);
}

function nextPostInGroup() {
  currentPostIndex++;
  showStoryGroup(currentStoryGroup, currentPostIndex);
}

function prevPostInGroup() {
  currentPostIndex--;
  showStoryGroup(currentStoryGroup, currentPostIndex);
}

function nextStoryGroup() {
  currentStoryGroup++;
  if (currentStoryGroup >= stories.length) currentStoryGroup = 0;
  showStoryGroup(currentStoryGroup, 0);
}

function prevStoryGroup() {
  currentStoryGroup--;
  if (currentStoryGroup < 0) currentStoryGroup = stories.length - 1;
  showStoryGroup(currentStoryGroup, 0);
}

function deletePost(postIndex) {
  let localStories = JSON.parse(localStorage.getItem("userStories")) || [];

  if (postIndex >= 0 && postIndex < localStories.length) {
    localStories.splice(postIndex, 1);
    localStorage.setItem("userStories", JSON.stringify(localStories));

    mergeStories();
    renderStoryList();

    // If no posts left, reset
    if (localStories.length === 0) {
      storyContent.innerHTML = `<h2>No Stories Available</h2>`;
      clearTimeout(timer);
    } else {
      showStoryGroup(0, 0);
    }
  }
}

nextBtn.addEventListener("click", () => {
  clearTimeout(timer);
  nextPostInGroup();
});

prevBtn.addEventListener("click", () => {
  clearTimeout(timer);
  prevPostInGroup();
});

// Swipe navigation
let touchStartX = 0;
let touchEndX = 0;

storyContainer.addEventListener("touchstart", (e) => {
  touchStartX = e.changedTouches[0].screenX;
});

storyContainer.addEventListener("touchend", (e) => {
  touchEndX = e.changedTouches[0].screenX;
  handleSwipe();
});

function handleSwipe() {
  const swipeThreshold = 50;
  if (touchEndX < touchStartX - swipeThreshold) {
    clearTimeout(timer);
    nextPostInGroup();
  }

  if (touchEndX > touchStartX + swipeThreshold) {
    clearTimeout(timer);
    prevPostInGroup();
  }
}

storyContainer.addEventListener("mouseover", () => clearTimeout(timer));
storyContainer.addEventListener("mouseout", () => startProgressAnimation());

mergeStories();
renderStoryList();
showStoryGroup(0, 0);
