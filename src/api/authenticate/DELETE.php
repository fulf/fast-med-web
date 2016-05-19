<?php
session_destroy();
gracefulExit(200, true, "Logged out successfully.");