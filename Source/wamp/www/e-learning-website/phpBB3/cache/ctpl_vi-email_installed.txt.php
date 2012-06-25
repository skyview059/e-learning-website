<?php if (!defined('IN_PHPBB')) exit; ?>Subject: phpBB đã được cài đặt thành công

Xin chúc mừng!

Bạn đã cài đặt thành công hệ thống phpBB trên máy chủ của mình.

Email này chứa những thông tin quan trọng trong quá trình cài đặt hệ thống của bạn, vì thế hãy cất giữ Email này an toàn. Mật khẩu đã được mã hoá trong cơ sở dữ liệu của hệ thống và không thể phục hồi lại được, mặc dù bạn có thể yêu cầu một mật khẩu mới nếu bạn lỡ quên mật khẩu hiện tại.

--------------------------------------------------------
Tên thành viên: <?php echo (isset($this->_rootref['USERNAME'])) ? $this->_rootref['USERNAME'] : ''; ?>

Mật khẩu: <?php echo (isset($this->_rootref['PASSWORD'])) ? $this->_rootref['PASSWORD'] : ''; ?>


Địa chỉ URL: <?php echo (isset($this->_rootref['U_BOARD'])) ? $this->_rootref['U_BOARD'] : ''; ?>

--------------------------------------------------------

Những thông tin hữu ích về việc cài đặt hệ thống phpBB bạn có thể tìm thấy trong thư mục "docs" của hệ thống hoặc tại trang hỗ trợ của phpBB.com - http://www.phpbb.com/support/

Ngoài ra, vì lý do giữ cho hệ thống an toàn và bảo mật, chúng tôi khuyến cáo bạn nên kiểm tra thường xuyên những thông tin phát hành về các phiên bản mới nhất của hệ thống bằng cách đăng ký tham gia vào danh sách Email thông báo của chúng tôi được cung cấp tại địa chỉ bên trên. Việc này rất nhanh chóng và dễ dàng.

<?php echo (isset($this->_rootref['EMAIL_SIG'])) ? $this->_rootref['EMAIL_SIG'] : ''; ?>