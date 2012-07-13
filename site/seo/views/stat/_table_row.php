<?php
/* @var $this Controller
 * @var $stats UserStats
 */

echo '<td>'.$stats->clubPostCount().'</td>';
echo '<td>'.$stats->clubVideoCount().'</td>';
echo '<td>'.$stats->clubCommentsCount().'</td>';

echo '<td>'.$stats->blogPostCount().'</td>';
echo '<td>'.$stats->blogVideoCount().'</td>';
echo '<td>'.$stats->blogCommentsCount().'</td>';

echo '<td>'.$stats->servicePostCount().'</td>';
echo '<td>'.$stats->serviceCommentsCount().'</td>';

echo '<td>'.$stats->guestBookCommentsCount().'</td>';

echo '<td>'.$stats->personalPhotoCount().'</td>';
echo '<td>'.$stats->servicesPhotoCount().'</td>';

echo '<td>'.$stats->messagesCount().'</td>';
echo '<td>'.$stats->friendsCount().'</td>';