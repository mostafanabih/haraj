<div style="background-image: radial-gradient(rgba(254,199,35,0), rgba(254,199,35,1));color: #111;padding: 20px;">
    <img alt="logo" width="150" height="150" src="<?php echo e($message->embed(public_path() . '/img/'.$img)); ?>">
    <h1>Hi, <?php echo e($name); ?></h1>
    <h3>Your Forget Password Code is : <span style="color: #67B86E"><?php echo e($active_code); ?></span></h3>

    <br><br>
    <h4>Best Regards,</h4>
    <p style="padding-left: 40px">Haraj One Team</p>
</div>
