<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div>
    <div class="slider-section">
        <div class="owl-carousel owl-theme" id="home-slider">
            <div class="owl-slide d-flex align-items-center cover" style="background-image:url('<?php echo base_url($images_dir . '/'); ?>other-apge.png');">
                <div class="container">
                    <div class="row justify-content-center justify-content-md-start">
                        <div class="col-md-12 ">
                            <div class="owl-slide-text">
                                <h2 class="owl-slide-animated owl-slide-title">Negotiation Made Easy</h2>
                                <h3>Now save yp to 10% on every requirements<br>by using our auction tools</h3>
                                <p>Forword Auction<br>Reverse Auction</p>
                                <div class="owl-slide-animated owl-slide-subtitle"> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="action-section1">
        <div class="container my-5">
            <div class="row">
                <div class="col-md-7">
                    <div class="d-flex align-items-start">
                        <div class="mr-4">
                            <h3>Auctions</h3>
                            <p>An auction is the process of buying and selling things by offering them up for bid,
                                taking bids, and then selling the item to the economical bidder. In economic theory,
                                an auction is a method for determining the value of a commodity that has an
                                undetermined or variable price.</p>
                            <p>There are two types of Auction</p>
                            <ul>
                                <li>Forward Auction (Used for selling goods or services)</li>
                                <li>Reverse Auction (Used for buying goods or services)</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 text-align-left"> <img src="<?php echo base_url($images_dir . '/'); ?>b-auction.png"> </div>
            </div>
        </div>
    </section>
    <section class="action-section1">
        <div class="container my-5">
            <div class="row">
                <div class="col-md-7">
                    <div class="d-flex align-items-start">
                        <div class="mr-4">
                            <h3>Forward Auction</h3>
                            <p>Forward auctions take the form of a single seller offering an item for sale, with
                                buyers competing to secure the item by bidding the price upward. Forward auctions
                                are far-better understood by the public at large than reverse auctions as to how
                                they operate, due primarily to the fact that they are widely used at the consumer
                                level. They are also widely used when the goal is for the seller to receive the most
                                money possible for the item being offered at auction.</p>
                            <h6 style="font-weight: 600;">When to use Forward Auction?</h6>
                            <p>For selling scrap, used or idle machinery or componenets, antique items, and etc.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 text-align-left"> <img src="<?php echo base_url($images_dir . '/'); ?>c-auction.png"> </div>
            </div>
        </div>
    </section>
    <section class="action-table-section1">
        <div class="container ">
            <div class="row">
                <div class="tab">
                    <button class="tablinks active" onclick="openCity(event, 'London')">Schedule a Reverse
                        Auction</button>
                    <button class="tablinks" onclick="openCity(event, 'Paris')">Ongoing Auctions</button>
                </div>
            </div>
        </div>
    </section>
    <section class="action-section1">
        <div class="container my-5">
            <div class="row">
                <div class="col-md-7 p-7">
                    <div class="d-flex align-items-start">
                        <div class="mr-4">
                            <h3>Reverse Auction</h3>
                            <p>Reverse auctions are the other major form of auctions. In a reverse auction, a single
                                buyer makes potential sellers aware of their intent to buy a specified good or
                                service. During the course of the actual reverse auction event, the sellers bid
                                against one another to secure the buyer’s business, driving the price to be paid for
                                the item downward. Thus, the winning bidder is the seller who offers the lowest
                                price. Reverse auctions are most typically used for procurement by private
                                companies, public sector agencies and nonprofit organizations.</p>
                            <p>Types of Reverse Auction available on our portal:</p>
                            <h6 style="font-weight: 600;">1. English Reverse Auction</h6>
                            <p>A supplier can only submit a bid if its numbers beat the current best price. The
                                process works best when the buyer is comfortable with attaching a value to their
                                project, allowing them to quickly settle negotiations. </p>
                            <h6 style="font-weight: 600;">When to use English Reverse Auction?</h6>
                            <p>English or Open Reverse Auction is generally used when price is the only parameter
                                while taking decision. Used while purchasing commodities like steel, paper, coal,
                                etc.</p>
                            <h6 style="font-weight: 600;">2. Ranked Reverse Auction</h6>
                            <p>The key information provided to the suppliers in ranked auctions is their position or
                                rank against the other bids. At any point, the supplier with the leading bid is the
                                only one who has knows what the current best price is.</p>
                            <h6 style="font-weight: 600;">When to use Ranked Reverse Auction?</h6>
                            <p>Ranked Reverse Auction is generally used when only price is not imporatnt enough to
                                award othe order or contract. Used while purchasing strategical important equipment
                                or machinery. </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 text-align-left"> <img src="<?php echo base_url($images_dir . '/'); ?>d-auction.png"> </div>
            </div>
        </div>
    </section>
    <section class="action-table-section1">
        <div class="container ">
            <div class="row">
                <div class="tab">
                    <button class="tablinks active" onclick="openCity(event, 'London')">Schedule a Reverse
                        Auction</button>
                    <button class="tablinks" onclick="openCity(event, 'Paris')">Ongoing Auctions</button>
                </div>
                <div id="London" class="tabcontent table-section">
                    <h6 style="color:#0612c3;font-weight: 600;margin-bottom: 30px;">Ongoing Auctions</h6>
                    <table class="action-table">
                        <tbody>
                            <tr>
                                <th>Auction Type</th>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Scheduled Date</th>
                                <th>Ref. No.</th>
                                <th>Bid Now</th>
                            </tr>
                            <tr>
                                <td>FA</td>
                                <td>Transmission Equipment</td>
                                <td>Description</td>
                                <td>22-06-2022</td>
                                <td style="color:#0612c3 !important">FA121</td>
                                <td><a href="#"><i class="fa fa-angle-right"></i></a></td>
                            </tr>
                            <tr>
                                <td>FA</td>
                                <td>Transmission Equipment</td>
                                <td>Description</td>
                                <td>22-06-2022</td>
                                <td style="color:#0612c3 !important">FA121</td>
                                <td><a href="#"><i class="fa fa-angle-right"></i></a></td>
                            </tr>
                            <tr>
                                <td>FA</td>
                                <td>Transmission Equipment</td>
                                <td>Description</td>
                                <td>22-06-2022</td>
                                <td style="color:#0612c3 !important">FA121</td>
                                <td><a href="#"><i class="fa fa-angle-right"></i></a></td>
                            </tr>
                            <tr>
                                <td>FA</td>
                                <td>Transmission Equipment</td>
                                <td>Description</td>
                                <td>22-06-2022</td>
                                <td style="color:#0612c3 !important">FA121</td>
                                <td><a href="#"><i class="fa fa-angle-right"></i></a></td>
                            </tr>
                            <tr>
                                <td>FA</td>
                                <td>Transmission Equipment</td>
                                <td>Description</td>
                                <td>22-06-2022</td>
                                <td style="color:#0612c3 !important">FA121</td>
                                <td><a href="#"><i class="fa fa-angle-right"></i></a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div id="Paris" class="tabcontent table-section">
                </div>
            </div>
        </div>
    </section>
</div>